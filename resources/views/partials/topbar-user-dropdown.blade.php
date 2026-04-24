<div class="shrink-0" data-kt-dropdown="true" data-kt-dropdown-trigger="click" data-kt-dropdown-placement="bottom-end" data-kt-dropdown-placement-rtl="bottom-end">
    <div class="cursor-pointer shrink-0" data-kt-dropdown-toggle="true">
        @if ($activeUser && $activeUser->photo && checkExistFile($activeUser->photo))
            <img alt="{{ $activeUser?->name ?? __('main.unknown_user') }}" class="border-2 border-green-500 rounded-full size-9 shrink-0"
                src="{{ asset('storage/' . $activeUser->photo) }}" />
        @else
            <span class="image-character" style="min-width: 35px; min-height: 35px; font-size: 14px;">
                <span class="pb-1">
                    {{ env('CHARACTER_LENGTH', 1) == 2
                        ? ($activeUser?->name[1]
                            ? lcfirst($activeUser?->name[0]) . lcfirst($activeUser?->name[1])
                            : lcfirst($activeUser?->name[0]))
                        : lcfirst($activeUser?->name[0]) }}
                </span>
            </span>
        @endif
    </div>
    <div class="kt-dropdown-menu w-[300px] z-[9999]" data-kt-dropdown-menu="true">
        <div class="flex items-center justify-between gap-1.5 px-2.5 py-1.5">
            <div class="flex items-center gap-2">
                @if ($activeUser && $activeUser->photo && checkExistFile($activeUser->photo))
                    <img alt="{{ $activeUser?->name ?? __('main.unknown_user') }}" class="border-2 border-green-500 rounded-full size-9 shrink-0"
                        src="{{ asset('storage/' . $activeUser->photo) }}" />
                @else
                    <span class="image-character" style="min-width: 35px; min-height: 35px; font-size: 14px;">
                        <span class="pb-1">
                            {{ env('CHARACTER_LENGTH', 1) == 2
                                ? ($activeUser?->name[1]
                                    ? lcfirst($activeUser?->name[0]) . lcfirst($activeUser?->name[1])
                                    : lcfirst($activeUser?->name[0]))
                                : lcfirst($activeUser?->name[0]) }}
                        </span>
                    </span>
                @endif

                <div class="flex flex-col gap-1.5">
                    <span class="text-sm font-semibold leading-none text-foreground">
                        {{ $activeUser?->name ?? __('main.unknown_user') }}
                    </span>
                    <a class="text-xs font-medium leading-none hover:text-primary text-secondary-foreground" href="#">
                        {{ $activeUser?->email ?? __('main.unknown_email') }}
                    </a>
                </div>
            </div>
            <span class="kt-badge kt-badge-sm kt-badge-primary kt-badge-outline">
                Pro
            </span>
        </div>
        <ul class="kt-dropdown-menu-sub">
            <li>
                <div class="kt-dropdown-menu-separator"></div>
            </li>
            <li>
                <a class="kt-dropdown-menu-link" href="{{ route('dashboard.core.user.profile') }}">
                    <i class="fa-duotone fa-solid fa-user-circle">
                    </i>
                    {{ __('main.my_profile') }}
                </a>
            </li>
            <li data-kt-dropdown="true" data-kt-dropdown-placement="right-start" data-kt-dropdown-placement-rtl="left-start" data-kt-dropdown-trigger="hover">
                <button class="py-1 kt-dropdown-menu-toggle" data-kt-dropdown-toggle="true">
                    <span class="flex items-center gap-2">
                        <i class="fa-duotone fa-solid fa-globe"></i>
                        {{ __('main.language') }}
                    </span>
                    <span class="kt-badge kt-badge-stroke ms-auto shrink-0">
                        @php
                            $currentLang = $system_languages->firstWhere('code', getCurrentLocale());
                            $currentLangName = $currentLang ? ($currentLang->native ?? $currentLang->name) : strtoupper(getCurrentLocale());
                            
                            // Priority: 1) Admin-uploaded flag  2) Metronic SVG  3) Default logo
                            $currentCountryCodeMap = [
                                'en' => 'gb', 'ar' => 'sa', 'es' => 'es', 'it' => 'it',
                                'fr' => 'fr', 'ja' => 'jp', 'tr' => 'tr', 'de' => 'de',
                                'ru' => 'ru', 'he' => 'il'
                            ];
                            $cCode = $currentCountryCodeMap[getCurrentLocale()] ?? getCurrentLocale();
                            $currentLangPath = 'assets/media/flags/' . $cCode . '.svg';
                            if ($currentLang && $currentLang->photo && checkExistFile($currentLang->photo)) {
                                $currentFlagUrl = asset('storage/' . $currentLang->photo);
                            } elseif (file_exists(public_path($currentLangPath))) {
                                $currentFlagUrl = asset($currentLangPath);
                            } else {
                                $currentFlagUrl = asset('assets/images/logos/default-logo.svg');
                            }
                        @endphp
                        {{ $currentLangName }}
                        <img alt="{{ $currentLangName }}" class="inline-block size-3.5 rounded-full object-cover ms-2"
                            src="{{ $currentFlagUrl }}" />
                    </span>
                </button>
                <div class="kt-dropdown-menu w-[180px] languages-dropdown-menu z-[9999]" data-kt-dropdown-menu="true">
                    <ul class="kt-dropdown-menu-sub">
                        @foreach ($system_languages as $key => $language)
                            <li class="{{ getCurrentLocale() == $language->code ? 'active disabled' : '' }}">
                                <a class="kt-dropdown-menu-link" href="{{ route('dashboard.localization.system-languages.change', $language->code) }}">
                                    <span class="flex items-center gap-2">
                                        @php
                                            // Priority: 1) Admin-uploaded flag  2) Metronic SVG  3) Default logo
                                            $countryCodeMap = [
                                                'en' => 'gb', 'ar' => 'sa', 'es' => 'es', 'it' => 'it',
                                                'fr' => 'fr', 'ja' => 'jp', 'tr' => 'tr', 'de' => 'de',
                                                'ru' => 'ru', 'he' => 'il'
                                            ];
                                            $countryCode = $countryCodeMap[$language->code] ?? $language->code;
                                            $flagPath = 'assets/media/flags/' . $countryCode . '.svg';
                                            if ($language->photo && checkExistFile($language->photo)) {
                                                $flagUrl = asset('storage/' . $language->photo);
                                            } elseif (file_exists(public_path($flagPath))) {
                                                $flagUrl = asset($flagPath);
                                            } else {
                                                $flagUrl = asset('assets/images/logos/default-logo.svg');
                                            }
                                        @endphp
                                        <img src="{{ $flagUrl }}" class="inline-block rounded-full size-4 object-cover">
                                        <span class="kt-menu-title">
                                            {{ $language->native ?? $language->name }}
                                        </span>
                                    </span>
                                    @if (getCurrentLocale() === $language->code)
                                        <i class="text-base text-green-500 fa-solid fa-circle-check ms-auto"></i>
                                    @endif
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </li>
            <li>
                <div class="kt-dropdown-menu-separator">
                </div>
            </li>
        </ul>
        <div class="mb-2.5 flex flex-col gap-3.5 px-2.5 pt-1.5">
            <div class="flex items-center justify-between gap-2">
                <span class="flex items-center gap-2">
                    <i class="text-base fa-duotone fa-solid fa-moon" id="icon-theme-mode"></i>
                    <span class="font-medium text-2sm" id="text-theme-mode">
                        {{ __('main.dark_mode') }}
                    </span>
                </span>
                <input class="kt-switch" id="switch-theme-mode" type="checkbox" value="1" />
            </div>
            <a class="justify-center w-full kt-btn kt-btn-outline cursor-pointer">
                <form action="{{ route('logout') }}" method="POST" class="w-full">
                    @csrf
                    <button type="submit" class="w-full text-center">{{ __('main.logout') }}</button>
                </form>
            </a>
        </div>
    </div>
</div>
<!-- End of User -->

{{-- Theme Mode --}}
@include('components.script-theme')
