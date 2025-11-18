<div class="flex flex-wrap items-end lg:items-center justify-between gap-2 lg:gap-4 pb-2" id="breadcrumb">
    <div class="flex flex-col justify-center gap-1 lg:gap-2">
        <h1 class="text-xl font-medium leading-none text-mono">
            {{ isset($title) ? $title : '' }}
        </h1>
        <div class="flex items-center flex-wrap gap-1.5 font-medium">
            <span class="text-base text-secondary-foreground">
                {{ isset($description) ? $description : '' }}
            </span>
        </div>
    </div>
    <div class="flex items-center gap-2.5 breadcrumb-buttons">
        @if (isset($import_url))
            <a class="kt-btn kt-btn-outline" href="{{ $import_url }}">
                {{ __('main.import_csv') }}
            </a>
        @endif
        <a class="kt-btn kt-btn-primary" href="{{ isset($page_create_url) ? $page_create_url : '#' }}">
            {{ isset($page_create_title) ? $page_create_title : '' }}
        </a>
    </div>
</div>
