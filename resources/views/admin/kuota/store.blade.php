<x-modal id="TambahKuota" labelledBy="exampleModalCenterTitle" title="Tambah Data Kuota">
	<form action="{{ route('dashboard.kuota.store') }}" method="POST">
		@csrf
		<div class="modal-body">
			<div class="mb-3">
				<label for="peserta" class="form-label">Peserta</label>
				<input type="text" name="peserta" class="form-control">
			</div>
			<div class="mb-3">
				<label for="kuota" class="form-label">kuota</label>
				<input type="number" name="kuota" class="form-control">
			</div>
			<div class="mb-3">
				<label for="status" class="form-label">Status</label>
				<select name="status" class="form-control">
					<option value="1">Aktif</option>
					<option value="0">Nonaktif</option>
				</select>
			</div>
		</div>
		<div class="modal-footer">
			<button type="button" class="btn btn-secondary" onclick="$('#TambahKuota').modal('hide');">Batal</button>
			<button type="submit" class="btn btn-primary">Simpan</button>
		</div>
	</form>
</x-modal>