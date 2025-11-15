<!-- User -->
<div class="shrink-0" data-kt-dropdown="true" data-kt-dropdown-offset="10px, 10px" data-kt-dropdown-offset-rtl="-20px, 10px"
    data-kt-dropdown-placement="bottom-end" data-kt-dropdown-placement-rtl="bottom-start" data-kt-dropdown-trigger="click">
    <div class="cursor-pointer shrink-0" data-kt-dropdown-toggle="true">
        <img alt="{{ $activeUser?->name ?? __('main.unknown_user') }}"
            class="border-2 border-green-500 rounded-full size-9 shrink-0"
            src="{{ $activeUser && $activeUser->photo ? asset('storage/' . $activeUser->photo) : asset('metronic/media/avatars/blank.png') }}" />
    </div>
    <div class="kt-dropdown-menu w-[300px]" data-kt-dropdown-menu="true">
        <div class="flex items-center justify-between gap-1.5 px-2.5 py-1.5">
            <div class="flex items-center gap-2">
                <img alt="{{ $activeUser?->name ?? __('main.unknown_user') }}"
                    class="border-2 border-green-500 rounded-full size-9 shrink-0"
                    src="{{ $activeUser && $activeUser->photo ? asset('storage/' . $activeUser->photo) : asset('metronic/media/avatars/blank.png') }}" />
                <div class="flex flex-col gap-1.5">
                    <span class="text-sm font-semibold leading-none text-foreground">
                        {{ $activeUser?->name ?? __('main.unknown_user') }}
                    </span>
                    <a class="text-xs font-medium leading-none hover:text-primary text-secondary-foreground"
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
                <button class="py-1 kt-dropdown-menu-toggle" data-kt-dropdown-toggle="true">
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
                <div class="kt-dropdown-menu w-[180px] languages-dropdown-menu" data-kt-dropdown-menu="true">
                    <ul class="kt-dropdown-menu-sub">
                        @foreach ($system_languages as $key => $language)
                            <li class="{{ getCurrentLocale() == $language->code ? 'active disabled' : '' }}">
                                <a class="kt-dropdown-menu-link"
                                    href="{{ route('system-languages.change', $language->code) }}">
                                    <span class="flex items-center gap-2">
                                        <img src="{{ $key <= 1 ? asset('metronic/media/flags/languages/' . $language->code . '.svg') : asset('storage/' . $language->flag) }}"
                                            class="inline-block rounded-full size-4">
                                        <span class="kt-menu-title">
                                            {{ __('languages.' . lcfirst($language->name)) ?? '' }}
                                        </span>
                                    </span>
                                    @if (getCurrentLocale() === $language->code)
                                        <i class="text-base text-green-500 ki-solid ki-check-circle ms-auto"></i>
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
                    <i class="text-base ki-filled ki-moon text-muted-foreground">
                    </i>
                    <span class="font-medium text-2sm">
                        {{ __('main.dark_mode') }}
                    </span>
                </span>
                <input class="kt-switch" data-kt-theme-switch-state="dark" data-kt-theme-switch-toggle="true"
                    name="check" type="checkbox" value="1" />
            </div>
            <a class="justify-center w-full kt-btn kt-btn-outline" href="{{ route('logout') }}">
                <form action="{{ route('logout') }}" method="POST" class="w-full">
                    @csrf
                    <button type="submit" class="w-full text-center">{{ __('main.logout') }}</button>
                </form>
            </a>
        </div>
    </div>
</div>
<!-- End of User -->
