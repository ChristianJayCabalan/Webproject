@if (session()->has('message'))
    <script>
        Swal.fire({
            icon: "success",
            title: "{{ session('message') }}",
            showConfirmButton: false,
            timer: 1000
        });
    </script>
@endif

@if (session()->has('removed'))
    <script>
        Swal.fire({
            icon: "warning",
            title: "{{ session('removed') }}",
            showConfirmButton: false,
            timer: 2000
        });
    </script>
@endif

@if (session()->has('error'))
    <script>
        Swal.fire({
            icon: "error",
            title: "{{ session('error') }}",
            showConfirmButton: false,
            timer: 2000 
        });
    </script>
@endif
