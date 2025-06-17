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
                @foreach ($jaket as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item->nama }}</td>
                        <td>{{ $item->email }}</td>
                        <td>{{ $item->user->dewasa }}</td>
                        <td>{{ $item->user->anak }}</td>
                        <td>{{ $item->user->jumlah_peserta }}</td>>
                        <td>
                            @php
                                $ukuranData = json_decode($item->tshirt_data, true);
                                $ukuranSummary = [];
                                foreach ($ukuranData as $ukuran) {
                                    if (isset($ukuranSummary[$ukuran['ukuran']])) {
                                        $ukuranSummary[$ukuran['ukuran']] += $ukuran['jumlah'];
                                    } else {
                                        $ukuranSummary[$ukuran['ukuran']] = $ukuran['jumlah'];
                                    }
                                }
                            @endphp
                            @foreach ($ukuranSummary as $ukuran => $jumlah)
                                <span>{{ $ukuran }} ({{ $jumlah }})</span><br>
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