<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Mail\QrCodeEmail;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\UserExport;
use App\Exports\UsersAndJaketsExport;

class AdminController extends Controller
{
    public function dashboard()
    {
        $user = User::orderBy('created_at', 'desc')->paginate(10);
        return view('admin.register.index', compact('user'));
    }

    public function registerUpdate(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $validated = $request->validate([
            'status' => 'required|in:belum,lunas,gagal'
        ]);

        if ($validated['status'] === 'lunas') {
            $user->update([
                'status' => 'lunas',
                'tanggal_lunas' => now()
            ]);
            $this->generateQrCodeAndSendEmail($id);
        } else {
            $user->update([
                'status' => $validated['status'],
                'tanggal_lunas' => null
            ]);
        }

        return redirect()->back()->with('success', 'Status berhasil diperbarui dan QR Code berhasil terkirim!');
    }

    public function registerDestroy(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return redirect()->back()->with('success', 'Data Berhasil Dihapus');
    }

    public function generateQrCodeAndSendEmail($id)
    {
        $user = User::findOrFail($id);

        $token = Str::random(32);
        $data = 'UserID:' . $user->id . '|Token:' . $token;

        $qrCodePath = 'qrcodes/' . $user->id . '.png';
        $qrCodeFullPath = storage_path('app/public/' . $qrCodePath);

        $qrCode = QrCode::format('png')->size(300)->margin(10)->backgroundColor(255, 255, 255)->generate($data);

        file_put_contents($qrCodeFullPath, $qrCode);

        $user->qr_code = $qrCodePath;
        $user->qr_token = $token;
        $user->save();

        Mail::to($user->email)->send(new QrCodeEmail($user, $qrCodePath));

        return back()->with('success', 'QR Code berhasil dikirim ke email!');
    }

    public function exportExcel()
    {
        return Excel::download(new UsersAndJaketsExport(), 'data.xlsx');
    }

    public function registerTable()
    {
        $user = User::orderBy('created_at', 'desc')->paginate(10);
        return view('admin.register.table', compact('user'));
    }
}
