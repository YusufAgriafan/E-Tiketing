@foreach($user as $item)

<x-modal id="EditStatus{{ $item->id }}" labelledBy="exampleModalCenterTitle" title="Edit Registrasi">
	<form action="{{ route('dashboard.register.update', $item->id) }}" method="POST">
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
				<label for="no_telepon" class="form-label">No Handphone</label>
				<input type="tel" name="no_telepon" class="form-control" value="{{ $item->no_telepon }}" disabled>
			</div>
			<div class="mb-3">
				<label for="jumlah_peserta" class="form-label">Jumlah Peserta</label>
				<input type="number" name="jumlah_peserta" class="form-control" value="{{ $item->jumlah_peserta }}" disabled>
			</div>
			<div class="mb-3">
				<label for="harga" class="form-label">Harga</label>
				<input type="number" name="harga" class="form-control" value="{{ $item->harga }}" disabled>
			</div>
			<div class="mb-3">
				<label for="status" class="form-label">Status</label>
				<select name="status" class="form-control">
					<option value="belum" {{ $item->status == 'belum' ? 'selected' : '' }}>Belum Lunas</option>
					<option value="lunas" {{ $item->status == 'lunas' ? 'selected' : '' }}>Lunas</option>
					<option value="gagal" {{ $item->status == 'gagal' ? 'selected' : '' }}>Gagal</option>
				</select>
			</div>
		</div>
		<div class="modal-footer">
			<button type="button" class="btn btn-secondary" onclick="$('#EditStatus{{ $item->id }}').modal('hide');">Batal</button>
			<button type="submit" class="btn btn-primary">Simpan</button>
		</div>
	</form>
</x-modal>

@endforeach