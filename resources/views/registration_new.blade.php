<x-layout2>
    <div class="row justify-content-center">
        <div class="col-xl-12 col-lg-10 col-md-12 pt-3">
            <div class="row">
                <div class="col-lg-12">
                    <div class="text-center">
                        <h1 class="h3 text-gray-900 mb-4 font-weight-bold">Form Registrasi Event</h1>
                        <p class="text-muted">Silakan isi formulir untuk registrasi</p>
                    </div>
                </div>
            </div>
            <div class="card o-hidden border-0 shadow-lg my-2" id="registrationCard">
                <div class="card-body p-0">
                    <div class="row">
                        <!-- Kolom Gambar -->
                        <div class="col-lg-6 col-12 d-lg-block p-lg-5 p-md-5 p-2">
                            <img src="{{ asset('/template/img/flyer.png') }}" alt="Gambar" class="w-100 rounded">
                        </div>
                        <!-- Kolom Form -->
                        <div class="col-lg-6">
                            <x-alert2></x-alert2>
                            <div class="p-2 p-lg-5 p-md-5">
                                <form class="user" action="{{ route('register.store') }}" method="POST">
                                    @csrf
                                    <div class="form-group">
                                        <label for="exampleInputNama">Nama Lengkap</label>
                                        <input type="text" class="form-control form-control-user"
                                            id="exampleInputNama" name="nama" placeholder="Nama Lengkap" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputEmail">Alamat Email</label>
                                        <input type="email" class="form-control form-control-user"
                                            id="exampleInputEmail" name="email" placeholder="Alamat Email" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputNoTelepon">Nomor Telepon</label>
                                        <input type="tel" class="form-control form-control-user"
                                            id="exampleInputNoTelepon" name="no_telepon" placeholder="Nomor Telepon"
                                            required>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputJumlahPeserta">Jumlah Peserta</label>
                                        <input type="number" class="form-control form-control-user"
                                            id="exampleInputJumlahPeserta" name="jumlah_peserta"
                                            placeholder="Masukkan jumlah peserta" required min="1">
                                    </div>

                                    <div class="form-group">
                                        <label for="exampleInputHarga">Total Harga</label>
                                        <input type="hidden" id="exampleInputHarga" name="harga">
                                        <input type="text" class="form-control form-control-user" id="displayHarga"
                                            placeholder="Rp0" readonly>
                                    </div>
                                    <button type="submit" class="btn c_btn-primary btn-user btn-block shadow-sm">
                                        Daftar Sekarang
                                    </button>
                                    <hr>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const jumlahPesertaInput = document.getElementById("exampleInputJumlahPeserta");
            const hargaInput = document.getElementById("exampleInputHarga");
            const displayHarga = document.getElementById("displayHarga");
            const form = document.querySelector("form.user");

            function formatRupiah(angka) {
                return new Intl.NumberFormat('id-ID', {
                    style: 'currency',
                    currency: 'IDR'
                }).format(angka);
            }

            function hitungHarga() {
                let jumlahPeserta = parseInt(jumlahPesertaInput.value) || 0;
                let hargaTotal = jumlahPeserta * 50000;

                hargaInput.value = parseInt(hargaTotal, 10);
                displayHarga.value = formatRupiah(hargaTotal);
            }

            jumlahPesertaInput.addEventListener("input", hitungHarga);
            jumlahPesertaInput.addEventListener("change", hitungHarga);

            form.addEventListener("submit", function(event) {
                hitungHarga();
                if (parseInt(hargaInput.value, 10) === 0) {
                    event.preventDefault();
                    Swal.fire("Error", "Jumlah peserta minimal 1!", "error");
                }
            });
        });
    </script>
</x-layout2>
