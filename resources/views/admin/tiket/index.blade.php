<x-layout>
    <!-- Begin Page Content -->
    <div class="container-fluid">

        <x-alert></x-alert>
        <h1 class="h3 mb-2 text-gray-800">Tabel Tiket</h1>
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Tabel Data Tiket</h6>
            </div>
            <div class="card-body">
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
                                @php
                                    $startNumber = ($tiket->currentPage() - 1) * $tiket->perPage();
                                @endphp
                                @foreach ($tiket as $item)
                                    <tr>
                                        <td>{{ $loop->iteration + $startNumber }}</td>
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
            </div>
        </div>

        <script>
            function refreshTable() {
                fetch('{{ route('dashboard.tiket.table') }}')
                    .then(response => response.text())
                    .then(data => {
                        const parser = new DOMParser();
                        const doc = parser.parseFromString(data, 'text/html');
                        const newTableBody = doc.querySelector('#table-body').innerHTML;
                        document.querySelector('#table-body').innerHTML = newTableBody;
                    });
            }
            setInterval(refreshTable, 10000);
        </script>
    </div>

</x-layout>
