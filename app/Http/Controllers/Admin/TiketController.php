<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class TiketController extends Controller
{
    public function tiket()
    {
        $tiket = User::where('naik_kapal', '>', 0)->orderBy('created_at', 'desc')->paginate(10);
        return view('admin.tiket.index', compact('tiket'));
    }

    public function tiketTable()
    {
        $tiket = User::where('naik_kapal', '>', 0)->orderBy('created_at', 'desc')->paginate(10);
        return view('admin.tiket.table', compact('tiket'));
    }
}
