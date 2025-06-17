<?php

namespace App\Http\Controllers;

use App\Models\Jaket;
use App\Models\User;
use App\Models\Kuota;
use App\Mail\RegisterEmail;
use Illuminate\Support\Str;
use App\Models\PopModel;
use App\Models\TestModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Console\View\Components\Alert;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class MainController extends Controller
{
    public function register()
    {
        return view('registration');
    }

    public function tshirt()
    {
        if (session()->has('id')) {
            $user = User::where('id', session('id'))->first();
            if ($user) {
                return view('form-tshirt', [
                    'id' => session('id'),
                    'nama' => session('nama'),
                    'email' => session('email'),
                    'jumlah_peserta' => session('jumlah_peserta')
                ]);
            }
        }
        return view('form-tshirt');
    }

    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate(
                [
                    'nama' => 'required|string|max:255',
                    'email' => 'required|string|email|max:255',
                    'no_telepon' => 'required|string|max:15',
                    'dewasa' => 'required|numeric|min:1',
                    'anak' => 'required|numeric|min:0'
                ],
                [
                    'dewasa.min' => 'Jumlah peserta dewasa minimal adalah 1.',
                    'anak.min' => 'Jumlah anak minimal adalah 0.'
                ]
            );

            $validatedData['jumlah_peserta'] = $validatedData['dewasa'] + $validatedData['anak'];

            $kuota = Kuota::where('status', true)->orderBy('created_at', 'asc')->first();
            if (!$kuota) {
                return back()->with('error', 'Kuota tidak tersedia saat ini.');
            }

            $jumlahPesertaLunas = User::where('status', 'lunas')->sum('jumlah_peserta');

            if ($jumlahPesertaLunas + $validatedData['jumlah_peserta'] > $kuota->kuota) {
                return back()->with(
                    'error',
                    'Maaf, jumlah peserta yang ingin didaftarkan melebihi kuota yang tersedia. Silakan sesuaikan jumlah peserta sesuai dengan kuota yang tersedia.'
                );
            }

            $totalHarga = $validatedData['dewasa'] * 1000000 + $validatedData['anak'] * 1000000;
            $kodeUnik = rand(100, 999);
            $hargaUnik = $totalHarga + $kodeUnik;

            $validatedData['harga'] = $hargaUnik;

            $lastUser = User::orderBy('id', 'desc')->first();
            $lastInvoiceNumber = $lastUser ? intval(substr($lastUser->invoice, 4)) : 0;
            $newInvoiceNumber = $lastInvoiceNumber + 1;
            $validatedData['invoice'] = 'INV-' . str_pad($newInvoiceNumber, 6, '0', STR_PAD_LEFT);

            $user = User::create($validatedData);

            session([
                'id' => $user->id,
                'nama' => $user->nama,
                'email' => $user->email,
                'jumlah_peserta' => $user->jumlah_peserta
            ]);

            return redirect()->route('tshirt');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function tshirtStore(Request $request)
    {
        $validatedData = $request->validate([
            'id' => 'required|integer',
            'nama' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'tshirt_data' => 'required'
        ]);

        $user = User::where('id', $validatedData['id'])->first();

        if (!$user) {
            return back()->with('error', 'Maaf, Registrasi terlebih dahulu untuk melanjutkan');
        }

        // $existingJaket = Jaket::where('email', $validatedData['email'])->first();
        // if ($existingJaket) {
        //     return back()->with('error', 'Maaf, Email yang kamu gunakan sudah terdaftar untuk pengambilan tshirt');
        // }

        $jaket = Jaket::create([
            'user_id' => $user->id,
            'nama' => $validatedData['nama'],
            'email' => $validatedData['email'],
            'tshirt_data' => $validatedData['tshirt_data']
        ]);
    

        $tshirtData = json_decode($validatedData['tshirt_data'], true);

        Mail::to($user)->send(new RegisterEmail($user, $user->harga));

        return redirect()
            ->route('tshirt')
            ->with(
                'success',
                json_encode([
                    'nama' => $user->nama,
                    'email' => $user->email,
                    'no_telepon' => $user->no_telepon,
                    'jumlah_peserta' => $user->jumlah_peserta,
                    'harga' => $user->harga
                ])
            );
    }

    public function popCallback(Request $request)
    {
        $dataRaw = json_encode($request->all());

        $dataTest = [
            'content' => $dataRaw
        ];

        $testAdd = TestModel::create($dataTest);

        $data = $request->all();

        $emailKey = array_keys(array_filter($data, fn($v) => filter_var($v, FILTER_VALIDATE_EMAIL)))[0] ?? null;
        $filesKey = array_keys(array_filter($data, fn($v) => is_array($v) && isset($v[0]['name'], $v[0]['size'], $v[0]['type'])))[0] ?? null;

        if (!$emailKey || !$filesKey) {
            return response()->json(['error' => 'Invalid data format'], 422);
        }

        $validator = Validator::make($request->all(), [
            "$emailKey" => 'required|email',
            "$filesKey" => 'required|array',
            "$filesKey.*.name" => 'required|string',
            "$filesKey.*.size" => 'required|integer',
            "$filesKey.*.type" => 'required|string',
            "$filesKey.*.quform_upload_uid" => 'required|string',
            "$filesKey.*.timestamp" => 'required|integer',
            "$filesKey.*.path" => 'required|string',
            "$filesKey.*.url" => 'required|url',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        foreach ($data[$filesKey] as $fileData) {
            $popData = [
                'email' => $data[$emailKey],
                'file_name' => $fileData['name'] ?? null,
                'file_size' => $fileData['size'] ?? null,
                'file_type' => $fileData['type'] ?? null,
                'file_path' => $fileData['path'] ?? null,
                'file_url' => $fileData['url'] ?? null,
            ];

            PopModel::create($popData);
        }

        Log::info('POP Callback received', $request->all());

        return response()->json(['message' => 'Data received successfully'], 200);
    }
}
