<?php

namespace App\Http\Controllers;

use App\Models\PopModel;
use Illuminate\Http\Request;

class PopController extends Controller
{
    //
    public function index()
    {
        $pops = PopModel::orderBy('created_at', 'desc')->paginate(10);

        if ($pops === null) {
            abort(404, 'Data tidak ditemukan');
        }

        return view('admin.bukti_bayar.index', compact('pops'));
    }
}
