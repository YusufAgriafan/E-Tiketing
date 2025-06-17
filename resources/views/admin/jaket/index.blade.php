<x-layout>
    <!-- Begin Page Content -->
    <div class="container-fluid">

        <x-alert></x-alert>
        <h1 class="h3 mb-2 text-gray-800">Tabel Jersey</h1>
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Tabel Data Jersey</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Email</th>
                                <th>Dewasa</th>
                                <th>Anak</th>
                                <th>Total Peserta</th>
                                <th>Ukuran</th>
                                <th>Tanggal Diambil</th>
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
                                <th>Ukuran</th>
                                <th>Tanggal Diambil</th>
                                <th>Status</th>
                            </tr>
                        </tfoot>
                        <tbody id="table-body">
                            @if (count($jaket))
                                @php
                                    $startNumber = ($jaket->currentPage() - 1) * $jaket->perPage();
                                @endphp
                                @foreach ($jaket as $item)
                                    <tr>
                                        <td>{{ $loop->iteration + $startNumber }}</td>
                                        <td>{{ $item->nama }}</td>
                                        <td>{{ $item->email }}</td>
                                        <td>{{ $item->user->dewasa }}</td>
                                        <td>{{ $item->user->anak }}</td>
                                        <td>{{ $item->user->jumlah_peserta }}</td>
                                        <td>
                                            @php
                                                $ukuranData = json_decode($item->tshirt_data, true);
                                                $ukuranSummary = [];
                                                foreach ($ukuranData as $ukuran) {
                                                    if (isset($ukuranSummary[$ukuran['ukuran']])) {
                                                        $ukuranSummary[$ukuran['ukuran']] += $ukuran['nama'];
                                                    } else {
                                                        $ukuranSummary[$ukuran['ukuran']] = $ukuran['nama'];
                                                    }
                                                }
                                            @endphp
                                            @foreach ($ukuranSummary as $ukuran => $nama)
                                                <span>{{ $ukuran }} ({{ $nama }})</span><br>
                                            @endforeach
                                        </td>
                                        <td>{{ $item->updated_at ?? '-' }}</td>
                                        <td>
                                            <span class="badge {{ $item->status ? 'badge-success' : 'badge-danger' }}"
                                                id="status-{{ $item->id }}">
                                                {{ $item->status ? 'Sudah Diambil' : 'Belum Diambil' }}
                                            </span>
                                        </td>
                                    </tr>
                                    @include('admin.jaket.edit', ['item' => $item])
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="9" class="text-center">Belum ada data</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                    {{ $jaket->links('pagination::bootstrap-4') }}
                </div>
            </div>
        </div>
    </div>

    <script>
        document.querySelectorAll('select[name="status"]').forEach(select => {
            select.addEventListener('change', function() {
                const id = this.closest('form').action.split('/').pop();
                const status = this.value;
                fetch(`/dashboard/jaket/update-status/${id}`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            status
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        const statusBadge = document.getElementById(`status-${id}`);
                        if (data.success) {
                            statusBadge.classList.remove('badge-success', 'badge-danger');
                            statusBadge.classList.add(data.status ? 'badge-success' : 'badge-danger');
                            statusBadge.textContent = data.status ? 'Sudah Diambil' : 'Belum Diambil';
                        }
                    });
            });
        });
    </script>

    <script>
        let isModalOpen = false;

        document.addEventListener('shown.bs.modal', function() {
            isModalOpen = true;
        });

        document.addEventListener('hidden.bs.modal', function() {
            isModalOpen = false;
        });

        function refreshTable() {
            if (!isModalOpen) {
                fetch('{{ route('dashboard.jaket.table') }}')
                    .then(response => response.text())
                    .then(data => {
                        const parser = new DOMParser();
                        const doc = parser.parseFromString(data, 'text/html');
                        const newTableBody = doc.querySelector('#table-body').innerHTML;
                        document.querySelector('#table-body').innerHTML = newTableBody;
                    });
            }
        }

        setInterval(refreshTable, 10000);
    </script>
</x-layout>

