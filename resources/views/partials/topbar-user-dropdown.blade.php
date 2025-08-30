<!-- User -->
<div class="shrink-0" data-kt-dropdown="true" data-kt-dropdown-offset="10px, 10px" data-kt-dropdown-offset-rtl="-20px, 10px"
    data-kt-dropdown-placement="bottom-end" data-kt-dropdown-placement-rtl="bottom-start" data-kt-dropdown-trigger="click">
    <div class="shrink-0 cursor-pointer" data-kt-dropdown-toggle="true">
        <img alt="{{ $activeUser?->name ?? __('main.unknown_user') }}"
            class="size-9 shrink-0 rounded-full border-2 border-green-500"
            src="{{ $activeUser && $activeUser->avatar_url ? asset('storage/' . $activeUser->avatar_url) : asset('metronic/media/avatars/blank.png') }}" />
    </div>
    <div class="kt-dropdown-menu w-[300px]" data-kt-dropdown-menu="true">
        <div class="flex items-center justify-between gap-1.5 px-2.5 py-1.5">
            <div class="flex items-center gap-2">
                <img alt="{{ $activeUser?->name ?? __('main.unknown_user') }}"
                    class="size-9 shrink-0 rounded-full border-2 border-green-500"
                    src="{{ $activeUser && $activeUser->avatar_url ? asset('storage/' . $activeUser->avatar_url) : asset('metronic/media/avatars/blank.png') }}" />
                <div class="flex flex-col gap-1.5">
                    <span class="text-sm font-semibold leading-none text-foreground">
                        {{ $activeUser?->name ?? __('main.unknown_user') }}
                    </span>
                    <a class="hover:text-primary text-xs font-medium leading-none text-secondary-foreground"
                        href="#">
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
                <a class="kt-dropdown-menu-link" href="{{ route('user.profile') }}">
                    <i class="ki-filled ki-profile-circle">
                    </i>
                    {{ __('main.my_profile') }}
                </a>
            </li>
            <li data-kt-dropdown="true" data-kt-dropdown-placement="right-start" data-kt-dropdown-trigger="hover">
                <button class="kt-dropdown-menu-toggle py-1" data-kt-dropdown-toggle="true">
                    <span class="flex items-center gap-2">
                        <i class="ki-filled ki-global"></i>
                        {{ __('main.language') }}
                    </span>
                    <span class="kt-badge kt-badge-stroke ms-auto shrink-0">
                        {{ config('languages.languages.' . getCurrentLocale()) }}
                        <img alt="" class="inline-block size-3.5 rounded-full"
                            src="{{ asset('metronic/media/flags/languages/' . getCurrentLocale() . '.svg') }}" />
                    </span>
                </button>
                <div class="kt-dropdown-menu w-[180px]" data-kt-dropdown-menu="true">
                    <ul class="kt-dropdown-menu-sub">
                        @foreach ($languages as $key => $language)
                            <li class="{{ getCurrentLocale() === $language->code ? 'active' : '' }}">
                                <a class="kt-dropdown-menu-link"
                                    href="{{ route('languages.change', $language->code) }}">
                                    <span class="flex items-center gap-2">
                                        <img src="{{ $key <= 1 ? asset('metronic/media/flags/languages/' . $language->code . '.svg') : asset('storage/' . $language->flag) }}"
                                            alt="{{ $language->name }}" class="inline-block size-4 rounded-full">
                                        <span class="kt-menu-title">
                                            {{ $language->name }}
                                        </span>
                                    </span>
                                    @if (getCurrentLocale() === $language->code)
                                        <i class="ki-solid ki-check-circle ms-auto text-base text-green-500"></i>
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
                    <i class="ki-filled ki-moon text-base text-muted-foreground">
                    </i>
                    <span class="text-2sm font-medium">
                        {{ __('main.dark_mode') }}
                    </span>
                </span>
                <input class="kt-switch" data-kt-theme-switch-state="dark" data-kt-theme-switch-toggle="true"
                    name="check" type="checkbox" value="1" />
            </div>
            <a class="kt-btn kt-btn-outline justify-center w-full" href="{{ route('logout') }}">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="w-full text-left">{{ __('main.logout') }}</button>
                </form>
            </a>
        </div>
    </div>
</div>
<!-- End of User -->
