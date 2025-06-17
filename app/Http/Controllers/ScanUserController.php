<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Zxing\QrReader;

class ScanUserController extends Controller
{
    public function scanner()
    {
        return view('scan.scan');
    }
    public function scanner1()
    {
        return view('scan.scan1');
    }

    public function scanner2()
    {
        return view('scan.scan2');
    }

    public function scanQR(Request $request)
    {
        $request->validate([
            'qr_code' => 'required|image|mimes:png|max:2048'
        ]);

        $file = $request->file('qr_code');

        try {
            $qrReader = new QrReader($file->getPathname());
            $text = $qrReader->text();

            if (!$text || !str_contains($text, '|Token:')) {
                return response()->json(
                    [
                        'success' => false,
                        'message' => 'File bukan QR Code yang valid!'
                    ],
                    400
                );
            }

            [$userId, $token] = explode('|Token:', str_replace('UserID:', '', $text));

            $user = User::where('id', $userId)->where('qr_token', $token)->first();

            if ($user) {
                return response()->json([
                    'success' => true,
                    'message' => 'QR Code Valid! User ditemukan: ' . $user->name
                ]);
            } else {
                return response()->json(
                    [
                        'success' => false,
                        'message' => 'QR Code tidak valid atau sudah kadaluarsa!'
                    ],
                    404
                );
            }
        } catch (\Exception $e) {
            return response()->json(
                [
                    'success' => false,
                    'message' => 'Gagal membaca QR Code!'
                ],
                500
            );
        }
    }

    public function liveScanQR(Request $request)
    {
        $request->validate([
            'qr_code' => 'required|string'
        ]);

        $qrCode = $request->input('qr_code');

        try {
            if (!str_contains($qrCode, '|Token:')) {
                return response()->json(
                    [
                        'success' => false,
                        'message' => 'QR Code tidak valid!'
                    ],
                    400
                );
            }
            [$userId, $token] = explode('|Token:', str_replace('UserID:', '', $qrCode));

            $user = User::where('id', $userId)->where('qr_token', $token)->first();

            if ($user) {
                return response()->json([
                    'success' => true,
                    'message' => 'QR Code Valid!',
                    'data' => [
                        'nama' => $user->nama,
                        'email' => $user->email,
                        'jumlah_peserta' => $user->jumlah_peserta,
                        'tanggal_lunas' => $user->status === 'lunas' ? $user->tanggal_lunas : null,
                        'harga' => $user->harga
                    ]
                ]);
            } else {
                return response()->json(
                    [
                        'success' => false,
                        'message' => 'QR Code tidak valid atau sudah kadaluarsa!'
                    ],
                    404
                );
            }
        } catch (\Exception $e) {
            return response()->json(
                [
                    'success' => false,
                    'message' => 'Gagal memproses QR Code!'
                ],
                500
            );
        }
    }

    public function scanQR1(Request $request)
    {
        $request->validate([
            'qr_code' => 'required|string'
        ]);

        $qrCode = $request->input('qr_code');

        try {
            if (!str_contains($qrCode, '|Token:')) {
                return response()->json(
                    [
                        'success' => false,
                        'message' => 'QR Code tidak valid!'
                    ],
                    400
                );
            }

            [$userId, $token] = explode('|Token:', str_replace('UserID:', '', $qrCode));

            $user = User::where('id', $userId)->where('qr_token', $token)->first();

            if (!$user) {
                return response()->json(
                    [
                        'success' => false,
                        'message' => 'QR Code Tidak Valid!'
                    ],
                    404
                );
            }

            if ($user->jersei) {
                return response()->json(
                    [
                        'success' => false,
                        'message' => 'QR Code Sudah Digunakan Sebelumnya!'
                    ],
                    409
                );
            }

            $user->update([
                'jersei' => true
            ]);

            return response()->json([
                'success' => true,
                'data' => [
                    'nama' => $user->nama,
                    'email' => $user->email,
                    'jumlah_peserta' => $user->jumlah_peserta,
                    'tanggal_lunas' => $user->status === 'lunas' ? $user->tanggal_lunas : null,
                    'harga' => $user->harga
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json(
                [
                    'success' => false,
                    'message' => 'Gagal Melakukan Scan!',
                    'error' => $e->getMessage()
                ],
                500
            );
        }
    }

    public function scanQR2(Request $request)
    {
        $request->validate([
            'qr_code' => 'required|string'
        ]);

        $qrCode = $request->input('qr_code');

        try {
            if (!str_contains($qrCode, '|Token:')) {
                return response()->json(
                    [
                        'success' => false,
                        'message' => 'QR Code tidak valid!'
                    ],
                    400
                );
            }

            [$userId, $token] = explode('|Token:', str_replace('UserID:', '', $qrCode));

            $user = User::where('id', $userId)->where('qr_token', $token)->first();

            if (!$user) {
                return response()->json(
                    [
                        'success' => false,
                        'message' => 'QR Code Tidak Valid!'
                    ],
                    404
                );
            }

            if ($user->kapal) {
                return response()->json(
                    [
                        'success' => false,
                        'message' => 'QR Code Sudah Digunakan Sebelumnya!'
                    ],
                    409
                );
            }

            $user->update([
                'kapal' => true
            ]);

            return response()->json([
                'success' => true,
                'data' => [
                    'nama' => $user->nama,
                    'email' => $user->email,
                    'jumlah_peserta' => $user->jumlah_peserta,
                    'tanggal_lunas' => $user->status === 'lunas' ? $user->tanggal_lunas : null,
                    'harga' => $user->harga
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json(
                [
                    'success' => false,
                    'message' => 'Gagal Melakukan Scan!',
                    'error' => $e->getMessage()
                ],
                500
            );
        }
    }
}
