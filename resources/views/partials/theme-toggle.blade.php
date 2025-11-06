<div>
    <!-- Theme Mode -->
    <script data-navigate-once>
        (function() {
            window.configToast = @json(config('app.app_theme', 'light'));

            const defaultThemeMode = window.configToast;
            let themeMode;

            if (document.documentElement) {
                if (localStorage.getItem('kt-theme')) {
                    themeMode = localStorage.getItem('kt-theme');
                } else if (document.documentElement.hasAttribute('data-kt-theme-mode')) {
                    themeMode = document.documentElement.getAttribute('data-kt-theme-mode');
                } else {
                    themeMode = defaultThemeMode;
                }
                if (themeMode == 'system') {
                    themeMode = window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';
                }
                document.documentElement.classList.add(themeMode);
                localStorage.setItem('kt-theme', themeMode);
            }
        })();
    </script>
    <!-- End of Theme Mode -->
</div>
