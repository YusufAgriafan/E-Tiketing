<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Jaket;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class JaketController extends Controller
{
    public function jaket()
    {
        $jaket = Jaket::whereHas('user', function ($query) {
            $query->where('status', 'lunas');
        })
            ->with('user')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('admin.jaket.index', compact('jaket'));
    }

    public function jaketUpdate(Request $request, $id)
    {
        $request->validate([
            'peserta' => 'required|string',
            'jaket' => 'required|integer',
            'status' => 'required|boolean'
        ]);
        $jaket = Jaket::findOrFail($id);
        $jaket->update($request->all());

        return back()->with('success', 'Data berhasil diperbarui!');
    }

    public function jaketDestroy(Request $request, $id)
    {
        $jaket = Jaket::findOrFail($id);
        $jaket->delete();
        return back()->with('success', 'jaket berhasil dihapus!');
    }

    public function updateStatus(Request $request, $id)
    {
        $jaket = Jaket::findOrFail($id);
        $jaket->status = $request->status;
        $jaket->save();

        return response()->json(['success' => true, 'status' => $jaket->status]);
    }

    public function jaketTable()
    {
        $jaket = Jaket::whereHas('user', function ($query) {
            $query->where('status', 'lunas');
        })
            ->with('user')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('admin.jaket.table', compact('jaket'));
    }
}
