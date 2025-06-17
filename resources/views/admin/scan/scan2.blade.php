<x-layout>
    <div class="container-fluid">
        <h1 class="h3 mb-3 text-gray-800 text-center">Scanner 2</h1>

        <div class="d-flex justify-content-center">
            <div id="reader" style="width: 500px;"></div>
        </div>

        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>

        <script>
            $(document).ready(function() {
                let isScanning = false;
    
                function onScanSuccess(decodedText, decodedResult) {
                    if (isScanning) return;
    
                    isScanning = true;
                    console.log(`Code matched = ${decodedText}`, decodedResult);
    
                    $.ajax({
                        url: "{{ route('dashboard.scanner2.qr') }}",
                        type: "POST",
                        data: {
                            qr_code: decodedText
                        },
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            Swal.fire({
                                html: `
                                    <div style="text-align: left; font-family: 'Arial', sans-serif; line-height: 1.6;">
                                        <p>Pembayaran sebesar <b>${response.data.harga.toLocaleString('id-ID', { style: 'currency', currency: 'IDR' })}</b> untuk <b>${response.data.jumlah_peserta} orang</b> telah terkonfirmasi.</p>
                                        <p style="margin-bottom: 2px;">Scan Register untuk
                                            <select id="naik_kapal" name="naik_kapal" style="width: auto; padding: 6px; border-radius: 5px; cursor: pointer;">
                                                ${Array.from({ length: response.data.remaining_participants }, (_, i) => `<option value="${i + 1}">${i + 1}</option>`).join('')}
                                            </select>
                                            orang
                                        </p>
                                        <p>Sisa peserta yang belum masuk venue <b><span id="remaining_participants">${response.data.remaining_participants}</span></b> orang</p>
                                        <p>Silakan menuju venue dan selamat menikmati acara.</p>
                                        <br>
                                        <p style="font-size: 16px; margin-bottom: 2px;">Salam,</p>
                                        <p style="font-size: 16px;">Panitia Event</p>
                                    </div>
                                `,
                                icon: "success",
                                didOpen: () => {
                                    const naikKapalInput = Swal.getPopup().querySelector(
                                        '#naik_kapal');
                                    const remainingParticipantsSpan = Swal.getPopup()
                                        .querySelector('#remaining_participants');
    
                                    naikKapalInput.addEventListener('input', () => {
                                        const remaining = response.data
                                            .remaining_participants - naikKapalInput
                                            .value;
                                        remainingParticipantsSpan.textContent =
                                            remaining >= 0 ? remaining : 0;
                                    });
                                },
                                preConfirm: () => {
                                    const naikKapal = Swal.getPopup().querySelector(
                                        '#naik_kapal').value;
                                    if (!naikKapal || naikKapal < 1 || naikKapal > response.data
                                        .remaining_participants) {
                                        Swal.showValidationMessage(
                                            `Mohon masukkan jumlah peserta yang valid`);
                                    }
                                    return {
                                        naik_kapal: naikKapal,
                                        nama: response.data.nama,
                                        email: response.data.email
                                    };
                                }
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    Swal.fire({
                                        title: "Konfirmasi",
                                        text: `Apakah Anda yakin ingin menyimpan data dengan jumlah peserta sebanyak ${result.value.naik_kapal} orang?`,
                                        icon: "warning",
                                        showCancelButton: true,
                                        confirmButtonText: "Ya, simpan",
                                        cancelButtonText: "Batal"
                                    }).then((confirmResult) => {
                                        if (confirmResult.isConfirmed) {
                                            $.ajax({
                                                url: "{{ route('dashboard.scanner2.naik_kapal') }}",
                                                type: "POST",
                                                data: {
                                                    naik_kapal: result.value
                                                        .naik_kapal,
                                                    nama: result.value.nama,
                                                    email: result.value.email
                                                },
                                                headers: {
                                                    'X-CSRF-TOKEN': $(
                                                        'meta[name="csrf-token"]'
                                                    ).attr('content')
                                                },
                                                success: function(response) {
                                                    Swal.fire({
                                                        title: "Berhasil",
                                                        text: "Data berhasil disimpan, silakan menuju venue dan selamat menikmati acara.",
                                                        icon: "success"
                                                    });
                                                },
                                                error: function(xhr) {
                                                    let errorMessage =
                                                        "Terjadi Kesalahan";
                                                    if (xhr.responseJSON && xhr
                                                        .responseJSON.message) {
                                                        errorMessage = xhr
                                                            .responseJSON
                                                            .message;
                                                    }
    
                                                    Swal.fire({
                                                        title: "Error",
                                                        text: errorMessage,
                                                        icon: "error"
                                                    });
                                                }
                                            });
                                        }
                                    });
                                }
                            });
    
                            setTimeout(() => {
                                isScanning = false;
                            }, 3000);
                        },
                        error: function(xhr) {
                            let errorMessage = "Terjadi Kesalahan";
                            if (xhr.responseJSON && xhr.responseJSON.message) {
                                errorMessage = xhr.responseJSON.message;
                            }
    
                            Swal.fire({
                                title: "Error",
                                text: errorMessage,
                                icon: "error"
                            });
    
                            setTimeout(() => {
                                isScanning = false;
                            }, 3000);
                        }
                    });
                }
    
                function onScanFailure(error) {
                    console.warn(`Code scan error = ${error}`);
                }
    
                let html5QrcodeScanner = new Html5QrcodeScanner(
                    "reader", {
                        fps: 10,
                        qrbox: {
                            width: 250,
                            height: 250
                        }
                    },
                    false
                );
                html5QrcodeScanner.render(onScanSuccess, onScanFailure);
            });
        </script>
        
    </div>
</x-layout>
