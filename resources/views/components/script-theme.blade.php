<script>
    const defaultThemeMode = @json(config('app.app_theme', 'system'));
    let switchThemeMode = document.getElementById('switch-theme-mode');
    let textThemeMode = document.getElementById('text-theme-mode');
    let iconThemeMode = document.getElementById('icon-theme-mode');

    // 🔹 Get saved theme
    let themeMode = localStorage.getItem('kt-theme') ?? null;

    // 🔹 Determine initial theme
    if (!themeMode) {
        if (document.documentElement.hasAttribute('data-kt-theme-mode')) {
            themeMode = document.documentElement.getAttribute('data-kt-theme-mode');
        } else {
            themeMode = defaultThemeMode;
        }
    }

    // 🔹 Handle system mode
    if (themeMode === 'system') {
        themeMode = window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';
    }

    if (switchThemeMode) {
        // 🔹 Set initial state of the switch
        switchThemeMode.checked = themeMode === 'dark' || themeMode === 'system' ? true : false;
        textThemeMode.innerText = ['dark', 'system'].includes(themeMode) ? @json(__('main.dark_mode')) :
            @json(__('main.light_mode'));

        // 🔹 Apply theme
        applyTheme(themeMode);

        // 🔹 Toggle theme on click
        switchThemeMode.addEventListener('click', function() {
            this.value = this.checked || themeMode === 'dark' || themeMode === 'system' ? '1' : '0';
            themeMode = document.documentElement.classList.contains('dark') ? 'light' : 'dark';
            applyTheme(themeMode);
            localStorage.setItem('kt-theme', themeMode);
        });

        // ================= Helpers =================
        function applyTheme(mode) {
            document.documentElement.classList.toggle('dark', mode === 'dark');
            textThemeMode.innerText = ['dark', 'system'].includes(themeMode) ? @json(__('main.dark_mode')) :
                @json(__('main.light_mode'));
            // Update icon
            iconThemeMode.classList.toggle('ki-sun', mode === 'light');
            iconThemeMode.classList.toggle('text-yellow-500', mode === 'light');
            iconThemeMode.classList.toggle('ki-moon', mode === 'dark');
            iconThemeMode.classList.toggle('text-blue-200', mode === 'dark');
        }
    }
</script>
