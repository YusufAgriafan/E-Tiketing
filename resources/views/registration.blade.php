<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Form Registrasi Event</title>
    <link rel="icon" href="{{ asset('/template/img/logo.ico') }}" type="image/x-icon" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="{{ asset('/template/css/registration.css ') }}" rel="stylesheet">
    <style>
        @media (max-width: 768px) {
            .participant-row .col-md-6 {
                margin-bottom: 15px;
            }

            .form-container .col-md-6 form {
                height: 75vh;
                /* Set a fixed height for the form */
                scrollbar-width: none;
                /* For Firefox */
                -ms-overflow-style: none;
                /* For Internet Explorer and Edge */
            }
        }

        /* Add vertical scrolling and hide scrollbar */
        .form-container .col-md-6 form {
            overflow-y: scroll;
            height: 56vh;
            /* Set a fixed height for the form */
            scrollbar-width: none;
            /* For Firefox */
            -ms-overflow-style: none;
            /* For Internet Explorer and Edge */
        }

        .form-container .col-md-6 form::-webkit-scrollbar {
            display: none;
            /* For Chrome, Safari, and Opera */
        }
    </style>
</head>

<body>
    {{-- <x-alert2></x-alert2> --}}
    <div class="container my-5">
        <h1 class="text-center title">Form Registrasi Event</h1>
        <p class="text-center text-muted mb-5 sub-title">
            Silakan isi formulir untuk registrasi
        </p>
        <div class="form-container row g-0">
            <div class="col-md-5 d-flex align-items-stretch">
                <img src="{{ asset('/template/img/flyer.png ') }}" alt="Event" class="event-image" />
            </div>
            <div class="col-md-1 d-none d-md-block">
                <div class="vertical-line"></div>
            </div>
            <div class="col-md-6 d-flex align-items-stretch">
                <form class="w-100" action="{{ route('register.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Nama Lengkap</label>
                        <input name="nama" type="text" class="form-control" required />
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Alamat Email</label>
                        <input name="email" type="email" class="form-control" required />
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nomor Telepon</label>
                        <input name="no_telepon" type="tel" class="form-control" required />
                    </div>
                    <h6 style="color: #495057;"><b>Peserta</b></h6>
                    <div id="participantRows">
                        <div class="row mb-3 participant-row">
                            <div class="col-md-6">
                                <label class="form-label">Nama Peserta</label>
                                <input type="text" class="form-control participant-name" name="participant_name[]"
                                    required />
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Tipe Peserta</label>
                                <div class="custom-select">
                                    <select class="form-control participant-type" name="participant_type[]" required>
                                        <option value="" disabled selected>Tipe Peserta</option>
                                        <option value="dewasa">Dewasa > 17th</option>
                                        <option value="anak">Anak-Anak 10 - 16th</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <p class="tambah" id="addParticipantBtn">+ Tambah Peserta</p>
                    <div class="mb-3">
                        <label class="form-label">Harga</label>
                        <input type="hidden" id="exampleInputHarga" name="harga">
                        <input type="text" class="form-control form-control-user" id="displayHarga" placeholder="Rp0"
                            readonly>
                    </div>
                    <input type="hidden" name="dewasa" value="0">
                    <input type="hidden" name="anak" value="0">
                    <button type="submit" class="btn w-100" id="submitBtn">
                        Lanjutkan
                    </button>
                </form>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @if (session('success') || session('error'))
        @if (session('success'))
            <script>
                document.addEventListener('DOMContentLoaded', function() {

                    Swal.fire({
                        title: 'Registrasi Berhasil!',
                        icon: 'success',
                        confirmButtonText: 'OK',
                    });
                });
            </script>
        @endif

        @if (session('error'))
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    Swal.fire({
                        title: 'Gagal!',
                        text: "{{ session('error') }}",
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                });
            </script>
        @endif
    @endif

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const participantRows = document.getElementById("participantRows");
            const addParticipantBtn = document.getElementById("addParticipantBtn");
            const hargaInput = document.getElementById("exampleInputHarga");
            const displayHarga = document.getElementById("displayHarga");
            const form = document.querySelector("form");
            const submitBtn = document.getElementById("submitBtn");

            function formatRupiah(angka) {
                return new Intl.NumberFormat('id-ID', {
                    style: 'currency',
                    currency: 'IDR'
                }).format(angka);
            }

            function hitungHarga() {
                const participantRows = document.querySelectorAll(".participant-row");
                let totalHarga = 0;
                let totalParticipant = 0;
                let totalDewasa = 0;
                let totalAnak = 0;
                participantRows.forEach(row => {
                    totalParticipant += 1;
                    totalHarga += 1000000;
                    const type = row.querySelector(".participant-type").value;
                    if (type === "dewasa") {
                        totalDewasa += 1;
                    } else if (type === "anak") {
                        totalAnak += 1;
                    } else {

                    }
                });
                hargaInput.value = totalHarga;
                displayHarga.value = formatRupiah(totalHarga);

                document.querySelector("input[name='dewasa']").value = totalDewasa;
                document.querySelector("input[name='anak']").value = totalAnak;
            }

            addParticipantBtn.addEventListener("click", function() {
                const newRow = document.createElement("div");
                newRow.classList.add("row", "mb-3", "participant-row");
                newRow.innerHTML = `
                    <div class="col-md-6">
                        <label class="form-label">Nama Peserta</label>
                        <input type="text" class="form-control participant-name" name="participant_name[]" required />
                    </div>  
                    <div class="col-md-6">
                        <label class="form-label">Tipe Peserta</label>
                        <div class="custom-select">
                            <select class="form-control participant-type" name="participant_type[]" required>
                                <option value="" disabled selected>Tipe Peserta</option>
                                <option value="dewasa">Dewasa > 17th</option>
                                <option value="anak">Anak-Anak 10 - 16th</option>
                            </select>
                        </div>
                    </div>
                `;
                participantRows.appendChild(newRow);
                newRow.querySelector(".participant-type").addEventListener("change", hitungHarga);
            });

            participantRows.addEventListener("input", hitungHarga);
            participantRows.addEventListener("change", hitungHarga);

            form.addEventListener("submit", function(event) {
                hitungHarga();
                if (parseInt(hargaInput.value, 10) === 0) {
                    event.preventDefault();
                    Swal.fire("Error", "Pilih tipe peserta terlebih dahulu!", "error");
                } else {
                    submitBtn.disabled = true;
                }
            });
        });
    </script>
</body>

</html>

