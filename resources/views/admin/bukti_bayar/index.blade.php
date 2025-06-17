<x-layout>
    <!-- Begin Page Content -->
    <div class="container-fluid">

        <x-alert></x-alert>
        <h1 class="h3 mb-2 text-gray-800">Tabel Bukti Pembayaran</h1>
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Tabel Data Pembayaran</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Email</th>
                                <th>File</th>
                                <th>Tanggal Upload</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>No</th>
                                <th>Email</th>
                                <th>File</th>
                                <th>Tanggal Upload</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            @if (count($pops))
                                @php
                                    $startNumber = ($pops->currentPage() - 1) * $pops->perPage();
                                @endphp
                                @foreach ($pops as $item)
                                    <tr>
                                        <td>{{ $loop->iteration + $startNumber }}</td>
                                        <td><b>{{ $item->email }}</b></td>
                                        <td><a href="{{ $item->file_url }}" target="_blank">{{ $item->file_name }}</td>
                                        <td>{{ $item->created_at }}</td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="7" class="text-center">Belum ada data</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                    {{ $pops->links('pagination::bootstrap-4') }}
                </div>
            </div>
        </div>

    </div>

</x-layout>
