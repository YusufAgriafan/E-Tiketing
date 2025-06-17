<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;

class UserExport implements FromCollection, WithTitle, WithHeadings
{
    public function collection()
    {
        return User::with('participants')
            ->select(
                'id',
                'nama',
                'email',
                'no_telepon',
                'harga',
                'jumlah_peserta',
                'dewasa',
                'anak',
                'status',
                'tanggal_lunas',
                \DB::raw('COALESCE(jersei, 0) as jersei'),
                \DB::raw('COALESCE(kapal, 0) as kapal'),
                \DB::raw("DATE_FORMAT(created_at, '%Y-%m-%d %H:%i:%s') as created_at"),
                \DB::raw("DATE_FORMAT(updated_at, '%Y-%m-%d %H:%i:%s') as updated_at")
            )
            ->get()
            ->map(function ($item) {
                $participants = $item->participants->map(function ($participant) {
                    return $participant->name . ' (' . $participant->type . ')';
                })->join(', ');

                return [
                    'id' => $item->id,
                    'nama' => $item->nama,
                    'email' => $item->email,
                    'no_telepon' => $item->no_telepon,
                    'harga' => number_format((int) $item->harga, 0, ',', '.'),
                    'jumlah_peserta' => $item->jumlah_peserta,
                    'dewasa' => $item->dewasa,
                    'anak' => $item->anak,
                    'status' => $item->status,
                    'tanggal_lunas' => $item->tanggal_lunas,
                    'jersei' => $item->jersei,
                    'kapal' => $item->kapal,
                    'participants' => $participants,
                    'created_at' => substr($item->created_at, 0, 19),
                    'updated_at' => substr($item->updated_at, 0, 19)
                ];
            });
    }

    public function title(): string
    {
        return 'Users';
    }

    public function headings(): array
    {
        return [
            'ID',
            'Nama',
            'Email',
            'No Telepon',
            'Harga',
            'Jumlah Peserta',
            'Dewasa',
            'Anak',
            'Status',
            'Tanggal Lunas',
            'Jersei',
            'Kapal',
            'Participants',
            'Created At',
            'Updated At'
        ];
    }
}
