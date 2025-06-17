<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Form Pemilihan Jersey</title>
    <link rel="icon" href="{{ asset('/template/img/logo.ico') }}" type="image/x-icon" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="{{ asset('/template/css/registration.css ') }}" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</head>

<body>
    <div class="container my-5">
        <h1 class="text-center title">Form Pemilihan Jersey</h1>
        <p class="text-center text-muted sub-title">Panduan Ukuran Jersey</p>
        <div class="size-guide mb-5">
            <div class="d-flex align-items-stretch">
                <img src="{{ asset('/template/img/sizePutra.png ') }}" alt="Chart Size Putra"
                    class="event-image-tshirt" />
            </div>
            <div class="d-flex align-items-stretch">
                <img src="{{ asset('/template/img/sizePutri.png ') }}" alt="Chart Size Putri"
                    class="event-image-tshirt" />
            </div>
            <div class="d-flex align-items-stretch">
                <img src="{{ asset('/template/img/sizeAnak.png ') }}" alt="Chart Size Anak"
                    class="event-image-tshirt" />
            </div>
        </div>
        <div class="form-container-tshirt">
            <form class="w-100" id="tshirtForm" method="POST" action="{{ route('tshirt.store') }}">
                @csrf
                <input type="hidden" name="id" value="{{ $id ?? null }}">
                <input type="hidden" name="nama" value="{{ $nama ?? null }}">
                <input type="hidden" name="email" value="{{ $email ?? null }}">
                <p class="row mb-2"><b style="color:#495057">Pemilihan Ukuran Jersey</b></p>
                <div id="tshirtRows">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Nama</label>
                            <input type="text" class="form-control nama" required />
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Ukuran</label>
                            <div class="custom-select">
                                <select class="form-control ukuran">
                                    <option>Putra - S</option>
                                    <option>Putra - M</option>
                                    <option>Putra - L</option>
                                    <option>Putra - XL</option>
                                    <option>Putra - 2XL</option>
                                    <option>Putra - 3XL</option>
                                    <option>Putri - S</option>
                                    <option>Putri - M</option>
                                    <option>Putri - L</option>
                                    <option>Putri - XL</option>
                                    <option>Putri - 2XL</option>
                                    <option>Putri - 3XL</option>
                                    <option>Anak - M</option>
                                    <option>Anak - L</option>
                                    <option>Anak - XL</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <p class="tambah" id="addRowBtn">+ Tambah Ukuran</p>
                <input type="hidden" name="tshirt_data" id="tshirtData">
                <button type="submit" class="btn w-100" id="submitBtn">Registrasi Sekarang</button>
            </form>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.getElementById('addRowBtn').addEventListener('click', function() {
            const newRow = document.createElement('div');
            newRow.classList.add('row', 'mb-3');
            newRow.innerHTML = `
                <div class="horizontal-line"></div>
                <div class="col-md-6">
                    <label class="form-label">Nama</label>
                    <input type="text" class="form-control nama"/>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Ukuran</label>
                    <div class="custom-select">
                        <select class="form-control ukuran">
                            <option disabled selected>Pilih Ukuran</option>
                                <option>Putra - S</option>
                                <option>Putra - M</option>
                                <option>Putra - L</option>
                                <option>Putra - XL</option>
                                <option>Putra - 2XL</option>
                                <option>Putra - 3XL</option>
                                <option>Putri - S</option>
                                <option>Putri - M</option>
                                <option>Putri - L</option>
                                <option>Putri - XL</option>
                                <option>Putri - 2XL</option>
                                <option>Putri - 3XL</option>
                                <option>Anak - M</option>
                                <option>Anak - L</option>
                                <option>Anak - XL</option>
                        </select>
                    </div>
                </div>
            `;
            document.getElementById('tshirtRows').appendChild(newRow);
        });

        document.getElementById('tshirtForm').addEventListener('submit', function(event) {
            const tshirtData = [];
            const rows = document.querySelectorAll('#tshirtRows .row');
            let totalJumlah = rows.length;
            rows.forEach(row => {
                const ukuran = row.querySelector('.ukuran').value;
                const nama = row.querySelector('.nama').value;
                if (ukuran && nama) {
                    tshirtData.push({
                        nama,
                        ukuran
                    });
                }
            });

            const jumlahPeserta = parseInt("{{ $jumlah_peserta ?? 0 }}");
            if (totalJumlah !== jumlahPeserta) {
                event.preventDefault();
                Swal.fire({
                    title: 'Gagal!',
                    text: `Jumlah t-shirt yang dipilih harus sama dengan jumlah peserta (${jumlahPeserta}).`,
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
                return;
            }

            document.getElementById('tshirtData').value = JSON.stringify(tshirtData);
            document.getElementById('submitBtn').disabled = true;
        });

        document.addEventListener('DOMContentLoaded', function() {
            const successMessage = @json(session('success'));
            const errorMessage = @json(session('error'));

            // console.log('Success Message:', successMessage);
            // console.log('Error Message:', errorMessage);

            let successData;
            if (successMessage) {
                successData = JSON.parse(successMessage);
            }

            if (successData) {
                Swal.fire({
                    title: 'Registrasi Berhasil!',
                    html: `<div style='text-align: left;'>
                            <table style='width: 100%;'>
                                <tr>
                                    <td style='width: 150px;'><strong>Nama</strong></td>
                                    <td>: ${successData.nama}</td>
                                </tr>
                                <tr>
                                    <td><strong>Email</strong></td>
                                    <td>: ${successData.email}</td>
                                </tr>
                                <tr>
                                    <td><strong>Nomor Telpon</strong></td>
                                    <td>: ${successData.no_telepon}</td>
                                </tr>
                                <tr>
                                    <td><strong>Jumlah Peserta</strong></td>
                                    <td>: ${successData.jumlah_peserta}</td>
                                </tr>
                                <tr>
                                    <td><strong>Jumlah Transfer</strong></td>
                                    <td>: ${new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(successData.harga)}</td>
                                </tr>
                            </table>
                            <br>
                            <p>Silakan cek email untuk melihat detail tujuan transfer pembayaran dan konfirmasi pembayaran.</p>
                            <p>Jika tidak menerima email dalam beberapa menit, harap periksa folder spam atau hubungi panitia untuk bantuan lebih lanjut di <strong>Contact: +628512345678 - Panitia</strong></p>
                            <p>Terima kasih!</p>`,
                    icon: 'success',
                    confirmButtonText: 'OK',
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = "{{ route('register') }}";
                    }
                });
            }

            if (errorMessage) {
                Swal.fire({
                    title: 'Gagal!',
                    text: errorMessage,
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            }
        });
    </script>

</body>

</html>

