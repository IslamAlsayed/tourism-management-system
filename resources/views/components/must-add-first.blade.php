@if (count($requirements) > 0)
    @php $hasUnmetRequirements = false; @endphp
    @foreach ($requirements as $requirement)
        @if (!$requirement['condition'])
            @php $hasUnmetRequirements = true; @endphp
        @endif
    @endforeach

    @if ($hasUnmetRequirements)
        <div class="kt-alert text-white flex items-center mb-4" style="background: #790004">
            <i class="fas fa-exclamation-circle"></i>
            {{ __('main.you_must_add') }}

            @php $unmetCount = 0; @endphp
            @foreach ($requirements as $requirement)
                @if (!$requirement['condition'])
                    @php $unmetCount++; @endphp

                    @if ($unmetCount > 1 && $unmetCount === count(array_filter($requirements, fn($r) => !$r['condition'])))
                        {{ __('main.and') }}
                    @elseif($unmetCount > 1)
                        ,
                    @endif

                    <a href="{{ $requirement['route'] }}" class="text-primary underline">
                        {{ $requirement['label'] }}
                    </a>
                @endif
            @endforeach
            {{ __('main.first') }}.
        </div>
    @endif
@endif
