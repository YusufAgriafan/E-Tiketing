<?php

namespace App\Exports;

use App\Models\Jaket;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;

class JaketExport implements FromCollection, WithTitle, WithHeadings
{
    // public function collection()
    // {
    //     return Jaket::all()->map(function ($jaket) {
    //         $tshirtData = json_decode($jaket->tshirt_data, true) ?? []; 
            
    //         // Ambil elemen pertama dari array jika ada
    //         $firstItem = $tshirtData[0] ?? [];
    
    //         return [
    //             'ID' => $jaket->id,
    //             'Nama' => $jaket->nama,
    //             'Email' => $jaket->email,
    //             'Ukuran' => $firstItem['ukuran'] ?? 'Tidak tersedia',
    //             'Jumlah' => $firstItem['jumlah'] ?? 0,
    //             'Status' => isset($jaket->status) ? ($jaket->status ? 'Aktif' : 'Tidak Aktif') : 'Tidak Diketahui',
    //             'Created At' => $jaket->created_at,
    //             'Updated At' => $jaket->updated_at
    //         ];
    //     });
    // }

    public function collection()
    {
        return Jaket::all()->map(function ($jaket) {
            $tshirtData = json_decode($jaket->tshirt_data, true) ?? [];

            $maxItems = max(array_map('count', [$tshirtData]));

            $data = [
                'ID' => $jaket->id,
                'Nama' => $jaket->nama,
                'Email' => $jaket->email,
                'Status' => isset($jaket->status) ? ($jaket->status ? 'Sudah Diambil' : 'Belum Diambil') : 'Tidak Diketahui',
                'Created At' => $jaket->created_at,
                'Updated At' => $jaket->updated_at
            ];

            for ($i = 0; $i < $maxItems; $i++) {
                $data["Nama " . ($i + 1)] = $tshirtData[$i]['nama'] ?? '0';
                $data["Ukuran " . ($i + 1)] = $tshirtData[$i]['ukuran'] ?? '-';
            }

            return $data;
        });
    }

    public function title(): string
    {
        return 'Jakets';
    }

    public function headings(): array
    {
        $maxItems = Jaket::all()->map(fn($jaket) => count(json_decode($jaket->tshirt_data, true) ?? []))->max();
    
        $headings = ['ID', 'Nama', 'Email', 'Status', 'Created At', 'Updated At'];
    
        for ($i = 0; $i < $maxItems; $i++) {
            $headings[] = "Nama " . ($i + 1);
            $headings[] = "Ukuran " . ($i + 1);
        }
    
        return $headings;
    }
}
