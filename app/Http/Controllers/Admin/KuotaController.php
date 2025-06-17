<?php

namespace App\Http\Controllers\Admin;

use App\Models\Kuota;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;

class KuotaController extends Controller
{
    public function kuota()
    {
        $kuota = Kuota::paginate(10);
        $user = User::get('jumlah_peserta')->sum('jumlah_peserta');
        return view('admin.kuota.index', compact('kuota', 'user'));
    }

    public function kuotaStore(Request $request)
    {
        $validatedData = $request->validate([
            'peserta' => 'required|string|max:255',
            'kuota' => 'required|numeric',
            'status' => 'required|boolean'
        ]);

        Kuota::create($validatedData);
        return back()->with('success', 'Data Berhasil Ditambahkan');
    }

    public function kuotaUpdate(Request $request, $id)
    {
        $request->validate([
            'peserta' => 'required|string',
            'kuota' => 'required|integer',
            'status' => 'required|boolean'
        ]);
        $kuota = Kuota::findOrFail($id);
        $kuota->update($request->all());

        return back()->with('success', 'Data berhasil diperbarui!');
    }

    public function kuotaDestroy(Request $request, $id)
    {
        $kuota = Kuota::findOrFail($id);
        $kuota->delete();
        return back()->with('success', 'Kuota berhasil dihapus!');
    }
}
