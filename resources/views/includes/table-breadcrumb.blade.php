<div class="flex flex-wrap items-center lg:items-end justify-between gap-5 pb-7.5">
    <div class="flex flex-col justify-center gap-2">
        <h1 class="text-xl font-medium leading-none text-mono">
            {{ $title }}
        </h1>
        <div class="flex items-center flex-wrap gap-1.5 font-medium">
            <span class="text-base text-secondary-foreground">
                {{ $description }}
            </span>
        </div>
    </div>
    <div class="flex items-center gap-2.5">
        @if (isset($import_url))
            <a class="kt-btn kt-btn-outline" href="{{ $import_url }}">
                {{ __('main.import_csv') }}
            </a>
        @endif
        <a class="kt-btn kt-btn-primary" href="{{ $page_add_url }}">
            {{ $page_add_title }}
        </a>
    </div>
</div>
