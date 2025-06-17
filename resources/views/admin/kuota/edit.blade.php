@foreach($kuota as $item)

<x-modal id="EditKuota{{ $item->id }}" labelledBy="exampleModalCenterTitle" title="Edit Data Kuota">
	<form action="{{ route('dashboard.kuota.update', $item->id) }}" method="POST">
		@csrf
		@method('PUT')
		<div class="modal-body">
			<div class="mb-3">
				<label for="peserta" class="form-label">Peserta</label>
				<input type="text" name="peserta" class="form-control" value="{{ $item->peserta }}">
			</div>
			<div class="mb-3">
				<label for="kuota" class="form-label">kuota</label>
				<input type="number" name="kuota" class="form-control" value="{{ $item->kuota }}">
			</div>
			<div class="mb-3">
				<label for="status" class="form-label">Status</label>
				<select name="status" class="form-control">
					<option value="1" {{ $item->status == 1 ? 'selected' : '' }}>Aktif</option>
					<option value="0" {{ $item->status == 0 ? 'selected' : '' }}>Nonaktif</option>
				</select>
			</div>
		</div>
		<div class="modal-footer">
			<button type="button" class="btn btn-secondary" onclick="$('#EditKuota{{ $item->id }}').modal('hide');">Batal</button>
			<button type="submit" class="btn btn-primary">Simpan</button>
		</div>
	</form>
</x-modal>

@endforeach