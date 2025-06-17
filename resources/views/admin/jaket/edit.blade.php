@foreach ($jaket as $item)
    <x-modal id="EditJaket{{ $item->id }}" labelledBy="exampleModalCenterTitle" title="Edit Data Jersey">
        <form action="{{ route('dashboard.jaket.update', $item->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="modal-body">
                <div class="mb-3">
                    <label for="nama" class="form-label">Nama</label>
                    <input type="text" name="nama" class="form-control" value="{{ $item->nama }}" disabled>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" value="{{ $item->email }}" disabled>
                </div>
                <div class="mb-3">
                    <label for="ukuran" class="form-label">Ukuran</label>
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
                        <input type="text" class="form-control mb-2"
                            value="{{ $ukuran }} ({{ $nama }})" disabled>
                    @endforeach
                </div>
                <div class="mb-3">
                    <label for="status" class="form-label">Status</label>
                    <select name="status" class="form-control">
                        <option value="1" {{ $item->status == 1 ? 'selected' : '' }}>Belum Diambil</option>
                        <option value="0" {{ $item->status == 0 ? 'selected' : '' }}>Sudah Diambil</option>
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary"
                    onclick="$('#EditJaket{{ $item->id }}').modal('hide');">Batal</button>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </form>
    </x-modal>
@endforeach

