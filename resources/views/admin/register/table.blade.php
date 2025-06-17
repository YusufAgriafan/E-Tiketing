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
        <tbody id="table-body">
            @if (count($user))
                @foreach ($user as $item)
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
                            <form action="{{ route('dashboard.register.destroy', ['id' => $item->id]) }}"
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
</div>
