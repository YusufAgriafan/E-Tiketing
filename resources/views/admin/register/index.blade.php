<x-layout>
    <!-- Begin Page Content -->
    <div class="container-fluid">

        <x-alert></x-alert>
        <h1 class="h3 mb-2 text-gray-800">Tabel Registrasi</h1>
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Tabel Data Registrasi</h6>
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
                                <th>Status</th>
                                <th>Aksi</th>
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
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </tfoot>
                        <tbody id="table-body">
                            @if (count($user))
                                @php
                                    $startNumber = ($user->currentPage() - 1) * $user->perPage();
                                @endphp
                                @foreach ($user as $item)
                                    <tr>
                                        <td>{{ $loop->iteration + $startNumber }}</td>
                                        <td>{{ $item->nama }}</td>
                                        <td>{{ $item->email }}</td>
                                        <td>{{ $item->dewasa }}</td>
                                        <td>{{ $item->anak }}</td>
                                        <td>
                                            {{ $item->jumlah_peserta }}
                                          
                                        </td>
                                        <td>{{ $item->no_telepon }}</td>
                                        <td>{{ $item->harga }}</td>
                                        <td>{{ $item->invoice }}</td>
                                        <td>
                                            <span
                                                class="badge 
                                        @if ($item->status == 'belum') badge-warning
                                        @elseif($item->status == 'lunas') badge-success
                                        @elseif($item->status == 'gagal') badge-danger @endif">
                                                {{ $item->status }}
                                            </span>
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-warning m-1" data-bs-toggle="modal"
                                                data-bs-target="#EditStatus{{ $item->id }}">
                                                <i class="fas fa-pencil-alt"></i>
                                            </button>
                                            <form
                                                action="{{ route('dashboard.register.destroy', ['id' => $item->id]) }}"
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

                                    @include('admin.register.edit')
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="10" class="text-center">Belum ada data</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                    {{ $user->links('pagination::bootstrap-4') }}
                </div>
            </div>
        </div>
        <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
        <script type="module" src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
        <script type="module" src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
        <script>
            let isModalOpen = false;

            document.addEventListener('shown.bs.modal', function() {
                isModalOpen = true;
            });

            document.addEventListener('hidden.bs.modal', function() {
                isModalOpen = false;
            });

            $(document).ready(function() {
                $('#dataTable').DataTable();
            });

            function refreshTable() {
                const route = `{{ route('dashboard.register.table') }}`;
                if (!isModalOpen) {
                    // Destroy existing DataTable instance if exists
                    if ( $.fn.DataTable.isDataTable('#dataTable') ) {
                        $('#dataTable').DataTable().destroy();
                    }
                    fetch(route)
                        .then(response => response.text())
                        .then(data => {
                            const parser = new DOMParser();
                            const doc = parser.parseFromString(data, 'text/html');
                            const newTableBody = doc.querySelector('#table-body').innerHTML;
                            document.querySelector('#table-body').innerHTML = newTableBody;
                            
                            // Reinitialize Bootstrap modals after content update
                            const modalTriggers = document.querySelectorAll('[data-bs-toggle="modal"]');
                            modalTriggers.forEach(trigger => {
                                new bootstrap.Modal(document.querySelector(trigger.dataset.bsTarget));
                            });
                            // Re-initialize DataTable
                            $('#dataTable').DataTable();
                        });
                }
            }

           // setInterval(refreshTable, 10000);
        </script>

    </div>

</x-layout>
