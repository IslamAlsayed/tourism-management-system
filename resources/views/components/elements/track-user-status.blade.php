<script>
    // Track user status when closing browser/tab
    window.addEventListener('beforeunload', function(e) {
        const data = new FormData();
        data.append('_token', '{{ csrf_token() }}');
        navigator.sendBeacon('{{ route('user.status.offline') }}', data);
    });

    let isPageVisible = true;
    document.addEventListener('visibilitychange', function() {
        if (document.hidden) {
            isPageVisible = false;
        } else {
            isPageVisible = true;
        }
    });

    // Auto logout when user is idle (30 minutes of inactivity)
    let idleTimeout;
    const IDLE_TIME = {{ config('app.idle_timeout', 1800000) }}; // 30 minutes default

    function resetIdleTimer() {
        clearTimeout(idleTimeout);
        idleTimeout = setTimeout(() => {
            // Send offline status
            fetch('{{ route('user.status.offline') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            }).then(() => {
                // Optional: redirect to logout or show idle message
                // window.location.href = '{{ route('logout') }}';
            });
        }, IDLE_TIME);
    }

    // Listen to user activity events
    ['mousedown', 'mousemove', 'keypress', 'scroll', 'touchstart', 'click'].forEach(event => {
        document.addEventListener(event, resetIdleTimer, {
            passive: true
        });
    });

    // Start the idle timer
    resetIdleTimer();
</script>
