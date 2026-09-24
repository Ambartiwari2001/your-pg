@if (session('success'))
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            if (window.Toast) {
                window.Toast.fire({
                    icon: 'success',
                    title: @json(session('success'))
                });
            }
        });
    </script>
@endif

@if (session('error'))
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            if (window.Toast) {
                window.Toast.fire({
                    icon: 'error',
                    title: @json(session('error'))
                });
            }
        });
    </script>
@endif

@if (session('warning'))
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            if (window.Toast) {
                window.Toast.fire({
                    icon: 'warning',
                    title: @json(session('warning'))
                });
            }
        });
    </script>
@endif

@if (session('info'))
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            if (window.Toast) {
                window.Toast.fire({
                    icon: 'info',
                    title: @json(session('info'))
                });
            }
        });
    </script>
@endif

@if (session('status'))
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            if (window.Toast) {
                window.Toast.fire({
                    icon: 'info',
                    title: @json(session('status'))
                });
            }
        });
    </script>
@endif
