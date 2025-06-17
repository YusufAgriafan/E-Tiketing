<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use Zxing\QrReader;
use App\Models\Jaket;

use App\Http\Controllers\Controller;

class ScanController extends Controller
{
    public function scanner1()
    {
        return view('admin.scan.scan1');
    }

    public function scanner2()
    {
        return view('admin.scan.scan2');
    }

    public function updateNaikKapal(Request $request)
    {
        $request->validate([
            'naik_kapal' => 'required|string',
            'nama' => 'required|string',
            'email' => 'required|string|email'
        ]);

        try {
            $user = User::where('nama', $request->input('nama'))->where('email', $request->input('email'))->first();

            if (!$user) {
                return response()->json(
                    [
                        'success' => false,
                        'message' => 'Maaf, User tidak ditemukan!'
                    ],
                    404
                );
            }

            $existingNaikKapal = (int) $user->naik_kapal;

            $newNaikKapal = $existingNaikKapal + $request->input('naik_kapal');

            if ($newNaikKapal > $user->jumlah_peserta) {
                return response()->json(
                    [
                        'success' => false,
                        'message' => 'Maaf, Jumlah melebihi jumlah peserta yang sudah didaftarkan!'
                    ],
                    400
                );
            }

            $user->update([
                'naik_kapal' => $newNaikKapal
            ]);

            if ($newNaikKapal == $user->jumlah_peserta) {
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
            }

            return response()->json([
                'success' => true,
                'message' => 'Naik Kapal berhasil diperbarui!'
            ]);
        } catch (\Exception $e) {
            return response()->json(
                [
                    'success' => false,
                    'message' => 'Gagal memperbarui Naik Kapal!',
                    'error' => $e->getMessage()
                ],
                500
            );
        }
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
                        'harga' => $user->harga,
                        'tshirt_data' => Jaket::where('user_id', $user->id)->pluck('tshirt_data')->first()
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
                    'message' => 'Gagal memproses QR Code!',
                    'error' => $e->getMessage()
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
                    'harga' => $user->harga,
                    'tshirt_data' => Jaket::where('user_id', $user->id)->pluck('tshirt_data')->first()
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

            $remainingParticipants = $user->jumlah_peserta - $user->naik_kapal;

            return response()->json([
                'success' => true,
                'data' => [
                    'nama' => $user->nama,
                    'email' => $user->email,
                    'jumlah_peserta' => $user->jumlah_peserta,
                    'naik_kapal' => $user->naik_kapal,
                    'remaining_participants' => $remainingParticipants,
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
