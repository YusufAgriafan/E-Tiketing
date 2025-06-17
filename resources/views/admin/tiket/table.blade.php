<div class="table-responsive" id="table-container">
    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Email</th>
                <th>Dewasa</th>
                <th>Anak</th>
                <th>Total Peserta</th>
                <th>No Telp</th>
                <th>Harga</th>
                <th>Invoice</th>
                <th>Belum Naik</th>
                <th>Status</th>
            </tr>
        </thead>
        <tfoot>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Email</th>
                <th>Dewasa</th>
                <th>Anak</th>
                <th>Total Peserta</th>
                <th>No Telp</th>
                <th>Harga</th>
                <th>Invoice</th>
                <th>Belum Naik</th>
                <th>Status</th>
            </tr>
        </tfoot>
        <tbody id="table-body">
            @if (count($tiket))
                @foreach ($tiket as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item->nama }}</td>
                        <td>{{ $item->email }}</td>
                        <td>{{ $item->dewasa }}</td>
                        <td>{{ $item->anak }}</td>
                        <td>{{ $item->jumlah_peserta }}</td>
                        <td>{{ $item->no_telepon }}</td>
                        <td>{{ $item->harga }}</td>
                        <td>{{ $item->invoice }}</td>
                        <td>{{ $item->jumlah_peserta - $item->naik_kapal }}</td>
                        <td>
                            <span class="badge {{ $item->kapal ? 'badge-success' : 'badge-danger' }}"
                                id="status-{{ $item->id }}">
                                {{ $item->kapal ? 'Sudah Semua' : 'Sebagian Belum' }}
                            </span>
                        </td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="11" class="text-center">Belum ada data</td>
                </tr>
            @endif
        </tbody>
    </table>
    {{ $tiket->links('pagination::bootstrap-4') }}
</div>
