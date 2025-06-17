<x-layout>
    <!-- Begin Page Content -->
    <div class="container-fluid">

        <x-alert></x-alert>
        <h1 class="h3 mb-2 text-gray-800">Tabel Kuota</h1>
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Daftar Tabel Kuota</h6>
            </div>
            <div class="card-body">
                <button type="button" class="btn btn-primary mb-3" data-toggle="modal" data-target="#TambahKuota">
                    Tambah Form
                </button>
                @include('admin.kuota.store')
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Setting</th>
                                <th>Kuota</th>
                                <th>Sisa Kuota</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>No</th>
                                <th>Nama Seeting</th>
                                <th>Kuota</th>
                                <th>Sisa Kuota</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            @if (count($kuota))
                                @php
                                    $startNumber = ($kuota->currentPage() - 1) * $kuota->perPage();
                                @endphp
                                @foreach ($kuota as $item)
                                    <tr>
                                        <td>{{ $loop->iteration + $startNumber }}</td>
                                        <td>{{ $item->peserta }}</td>
                                        <td>{{ $item->kuota }}</td>
                                        <td>{{ $item->status ? $item->kuota - $user : 'N/A' }}</td>
                                        <td>
                                            @if ($item->status)
                                                <span class="badge badge-success">Aktif</span>
                                            @else
                                                <span class="badge badge-danger">Nonaktif</span>
                                            @endif
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-warning m-1" data-bs-toggle="modal"
                                                data-bs-target="#EditKuota{{ $item->id }}">
                                                <i class="fas fa-pencil-alt"></i>
                                            </button>
                                            <form action="{{ route('dashboard.kuota.destroy', $item->id) }}"
                                                method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger m-1 border-0"
                                                    onclick="return confirm('Apakah kamu yakin ingin menghapus data ini?')">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                    @include('admin.kuota.edit')
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="5" class="text-center">Belum ada data</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                    {{ $kuota->links('pagination::bootstrap-4') }}
                </div>
            </div>
        </div>
    </div>

</x-layout>

