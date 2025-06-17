@if (session('success'))
    <script>
        Swal.fire({
            title: 'Sukses!',
            text: '{{ session('success') }}',
            icon: 'success',
            confirmButtonText: 'OK'
        });
    </script>
@elseif (session('error'))
    <script>
        Swal.fire({
            title: 'Gagal!',
            text: '{{ session('error') }}',
            icon: 'error',
            confirmButtonText: 'OK'
        });
    </script>
@elseif (session('warning'))
    <script>
        Swal.fire({
            title: 'Peringatan!',
            text: '{{ session('warning') }}',
            icon: 'warning',
            confirmButtonText: 'OK'
        });
    </script>
@elseif (session('info'))
    <script>
        Swal.fire({
            title: 'Informasi',
            text: '{{ session('info') }}',
            icon: 'info',
            confirmButtonText: 'OK'
        });
    </script>
@endif
