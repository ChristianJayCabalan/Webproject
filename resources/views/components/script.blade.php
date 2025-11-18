<!-- JS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('theme_asset/home/js/home.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <x-sweetalert />
    @livewireScripts

    <script>
function toggleDropdown(element) {
    const menu = element.nextElementSibling;
    menu.classList.toggle('show');

    // Close when clicking outside
    document.addEventListener('click', function(e) {
        if (!element.contains(e.target) && !menu.contains(e.target)) {
            menu.classList.remove('show');
        }
    }, { once: true });
}
</script>


    <script>
      document.addEventListener('livewire:initialized', () => {
        Livewire.on('swal', param => {
          Swal.fire({
            title: param[0].title || '',
            text: param[0].text || '',
            icon: param[0].icon || 'success',
            timer: param[0].timer || 2000,
            showConfirmButton: param[0].showConfirmButton ?? true,
          });
        });
      });

      document.addEventListener("DOMContentLoaded", function () {
        let confirmBtn = document.getElementById("confirmOrderBtn");
        if (confirmBtn) {
          confirmBtn.addEventListener("click", function (e) {
            e.preventDefault();
            Swal.fire({
              title: "Are you sure?",
              text: "Do you want to place this order?",
              icon: "question",
              showCancelButton: true,
              confirmButtonText: "Yes, confirm!",
              cancelButtonText: "Cancel"
            }).then((result) => {
              if (result.isConfirmed) {
                document.getElementById("confirmOrderForm").submit();
              }
            });
          });
        }
      });

      document.getElementById('logoutBtnMobile')?.addEventListener('click', function() {
    Swal.fire({
        title: 'Are you sure you want to logout?',
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Yes, logout',
        cancelButtonText: 'Cancel'
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('logoutFormMobile').submit();
        }
    });
});

    </script>

    <script>
  document.getElementById('logoutBtn').addEventListener('click', function() {
      Swal.fire({
          title: 'Are you sure you want to logout?',
          icon: 'question',
          showCancelButton: true,
          confirmButtonText: 'Yes, logout',
          cancelButtonText: 'Cancel'
      }).then((result) => {
          if (result.isConfirmed) {
              document.getElementById('logoutForm').submit();
          }
      });
  });
  
  </script>
    <!-- Age Verification Popup -->
    @if(session('show_age_popup'))
      <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
      <script>
        Swal.fire({
          title: 'Age Verification',
          text: 'Are you sure you are 18+?',
          icon: 'warning',
          showCancelButton: true,
          confirmButtonText: 'Yes, I am 18+',
          cancelButtonText: 'No',
          allowOutsideClick: false,
          allowEscapeKey: false
        }).then((result) => {
          if (result.isConfirmed) {
            fetch("{{ route('verify.age') }}", {
              method: "POST",
              headers: {
                "X-CSRF-TOKEN": "{{ csrf_token() }}",
                "Content-Type": "application/json"
              }
            }).then(() => {
              Swal.fire('Verified!', 'You can now access the site.', 'success');
            });
          } else {
            window.location.href = "{{ route('logout') }}";
          }
        });
      </script>
    @endif
