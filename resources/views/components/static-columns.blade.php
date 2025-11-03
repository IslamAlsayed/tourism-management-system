@switch($column)
    @case('id')
        <td title="{{ $model->id }}">{!! highlightSearch($model->id, $search) !!}</td>
    @break

    @case('user')
        <td title="{{ $model->name }}">
            <div class="flex items-center gap-2.5">
                <img src="{{ $model->photo ? asset('storage/' . $model->photo) : asset('metronic/media/avatars/blank.png') }}"
                    alt="{{ $model->name }}" class="rounded-full size-9 shrink-0">
                <div class="flex flex-col">
                    <a class="text-sm font-medium text-mono hover:text-primary mb-px" href="#">
                        {!! highlightSearch($model->name ?? '--', $search) !!}
                    </a>
                    <a class="text-sm text-secondary-foreground font-normal hover:text-primary" href="#">
                        {!! highlightSearch($model->email, $search) !!}
                    </a>
                </div>
            </div>
        </td>
    @break

    {{-- @case('photo')
        <td title="{{ $model->name }}">
            <div class="flex items-center gap-2.5">
                <img src="{{ $model->photo ? asset('storage/' . $model->photo) : asset('metronic/media/avatars/blank.png') }}"
                    alt="{{ $model->name }}" class="rounded-full size-9 shrink-0">
            </div>
        </td>
    @break --}}
    @case('photo')
        <td title="{{ $model->name }}">
            <img src="{{ $model->photo ? asset('storage/' . $model->photo) : asset('metronic/media/avatars/blank.png') }}"
                alt="{{ $model->name }}" class="rounded-full size-9 shrink-0">
        </td>
    @break

    @case('name')
        <td title="{{ $model->name }}">{!! highlightSearch(limitedText($model->name ?? '--', 30), $search) !!}</td>
    @break

    @case('email')
        <td title="{{ $model->email }}">{!! highlightSearch(limitedText($model->email ?? '--', 30), $search) !!}</td>
    @break

    @case('phone')
        <td title="{{ $model->phone }}">{!! highlightSearch(limitedText($model->phone ?? '--', 30), $search) !!}</td>
    @break

    @case('mobile')
        <td title="{{ $model->mobile }}">{!! highlightSearch(limitedText($model->mobile ?? '--', 30), $search) !!}</td>
    @break

    @case('position')
        <td title="{{ $model->position }}">{!! highlightSearch(limitedText($model->position ?? '--', 30), $search) !!}</td>
    @break

    @case('created_at')
        <td title="{{ $model->created_at?->format('Y-m-d') ?? '--' }}">{!! highlightSearch(limitedText($model->created_at?->format('Y-m-d') ?? '--', 30), $search) !!}</td>
    @break

    @case('code')
        <td title="{{ $model->code }}">{!! highlightSearch(limitedText($model->code ?? '--', 30), $search) !!}</td>
    @break

    @case('symbol')
        <td title="{{ $model->symbol }}">{!! highlightSearch(limitedText($model->symbol ?? '--', 30), $search) !!}</td>
    @break

    @case('route')
        <td title="{{ optional($model->car_route)->route }}">{!! highlightSearch(limitedText(optional($model->car_route)->route ?? '--', 30), $search) !!}</td>
    @break

    @case('route_ar')
        <td title="{{ optional($model->car_route)->route_ar }}">{!! highlightSearch(limitedText(optional($model->car_route)->route_ar ?? '--', 30), $search) !!}</td>
    @break

    @case('duration')
        <td title="{{ optional($model->car_route)->duration }}">{!! highlightSearch(limitedText(optional($model->car_route)->duration ?? '--', 30), $search) !!} {{ __('main.h') }}</td>
    @break

    @case('distance')
        <td title="{{ optional($model->car_route)->distance }}">{!! highlightSearch(limitedText(optional($model->car_route)->distance ?? '--', 30), $search) !!} {{ __('main.km') }}</td>
    @break

    @case('seats')
        <td title="{{ optional($model)->seats }}">{!! highlightSearch(limitedText(optional($model)->seats ?? '--', 30), $search) !!}</td>
    @break

    @case('price')
        <td title="{{ optional($model)->price }}">{!! highlightSearch(limitedText(optional($model)->price ?? '--', 30), $search) !!} {{ __('main.km') }}</td>
    @break

    @case('bus_type')
        <td title="{{ optional($model->bus_type)->name ?? '--' }}">{!! highlightSearch(limitedText(optional($model->bus_type)->name ?? '--', 30), $search) !!}</td>
    @break

    @case('currency')
        <td title="{{ optional($model->currency)->code ?? '--' }}">{!! highlightSearch(limitedText(optional($model->currency)->code ?? '--', 30), $search) !!}</td>
    @break

    @case('company')
        <td title="{{ optional($model->company)->name ?? '--' }}">{!! highlightSearch(limitedText(optional($model->company)->name ?? '--', 30), $search) !!}</td>
    @break

    @case('region')
        <td title="{{ optional($model->region)->name ?? '--' }}">{!! highlightSearch(limitedText(optional($model->region)->name ?? '--', 30), $search) !!}</td>
    @break

    @case('subregion')
        <td title="{{ optional($model->subregion)->name ?? '--' }}">{!! highlightSearch(limitedText(optional($model->subregion)->name ?? '--', 30), $search) !!}</td>
    @break

    @case('country')
        <td title="{{ optional($model->country)->name ?? '--' }}">{!! highlightSearch(limitedText(optional($model->country)->name ?? '--', 30), $search) !!}</td>
    @break

    @case('state')
        <td title="{{ optional($model->state)->name ?? '--' }}">{!! highlightSearch(limitedText(optional($model->state)->name ?? '--', 30), $search) !!}</td>
    @break

    @case('city')
        <td title="{{ optional($model->city)->name ?? '--' }}">{!! highlightSearch(limitedText(optional($model->city)->name ?? '--', 30), $search) !!}</td>
    @break

    @case('nationality')
        <td title="{{ optional($model->nationality)->name ?? '--' }}">{!! highlightSearch(limitedText(optional($model->nationality)->name ?? '--', 30), $search) !!}</td>
    @break

    @case('tour_guide')
        <td title="{{ optional($model->tour_guide)->name ?? '--' }}">{!! highlightSearch(limitedText(optional($model->tour_guide)->name ?? '--', 30), $search) !!}</td>
    @break

    @case('guide_type')
        <td title="{{ optional($model->guide_type)->type ?? '--' }}">{!! highlightSearch(limitedText(optional($model->guide_type)->type ?? '--', 30), $search) !!}</td>
    @break

    @case('type')
        <td title="{{ is_string($model->type) ? $model->type : optional($model->type)->name ?? '--' }}">
            {!! highlightSearch(
                limitedText(is_string($model->type) ? $model->type : optional($model->type)->name ?? '--', 30),
                $search,
            ) !!}
        </td>
    @break

    @case('state_id')
        <td>
            @if (!empty($model->states()))
                @foreach ($model->states() as $key => $state)
                    @if ($key <= 2)
                        @if ($state)
                            <div
                                class="inline-block bg-primary/10 text-primary text-xs font-medium px-2 py-0.5 rounded-[7px] ms-2">
                                {{ $state['name'] ?? '--' }}
                            </div>
                        @endif
                    @else
                        <div class="inline-block bg-primary/10 text-primary text-xs font-medium px-2 py-0.5 rounded-[7px] ms-2">
                            ...
                        </div>
                    @endif
                @endforeach
            @else
                <div
                    class="inline-block bg-primary/10 text-primary text-xs font-medium px-2 py-0.5 rounded-[7px] ms-2 user-select-none">
                    <i class="opacity-25">null</i>
                </div>
            @endif
        </td>
    @break

    @case('city_id')
        <td>
            @if (!empty($model->cities()))
                @foreach ($model->cities() as $key => $city)
                    @if ($key <= 2)
                        @if ($city)
                            <div
                                class="inline-block bg-primary/10 text-primary text-xs font-medium px-2 py-0.5 rounded-[7px] ms-2">
                                {{ $city['name'] ?? '--' }}
                            </div>
                        @endif
                    @else
                        <div class="inline-block bg-primary/10 text-primary text-xs font-medium px-2 py-0.5 rounded-[7px] ms-2">
                            ...
                        </div>
                    @endif
                @endforeach
            @else
                <div
                    class="inline-block bg-primary/10 text-primary text-xs font-medium px-2 py-0.5 rounded-[7px] ms-2 user-select-none">
                    <i class="opacity-25">null</i>
                </div>
            @endif
        </td>
    @break

    @case('all_states')
        <td title="{{ $model->all_states == 1 ? 'all' : '--' }}">
            @if ($model->all_states == 1)
                <div
                    class="inline-block bg-primary/10 text-primary text-xs font-medium px-2 py-0.5 rounded-[7px] ms-2 user-select-none">
                    {!! highlightSearch(limitedText($model->all_states == 1 ? 'all' : '--', 30), $search) !!}
                </div>
            @else
                <div
                    class="inline-block bg-primary/10 text-primary text-xs font-medium px-2 py-0.5 rounded-[7px] ms-2 user-select-none">
                    <i class="opacity-25">null</i>
                </div>
            @endif
        </td>
    @break

    @case('all_cities')
        <td title="{{ $model->all_cities == 1 ? 'all' : '--' }}">
            @if ($model->all_cities == 1)
                <div
                    class="inline-block bg-primary/10 text-primary text-xs font-medium px-2 py-0.5 rounded-[7px] ms-2 user-select-none">
                    {!! highlightSearch(limitedText($model->all_cities == 1 ? 'all' : '--', 30), $search) !!}
                </div>
            @else
                <div
                    class="inline-block bg-primary/10 text-primary text-xs font-medium px-2 py-0.5 rounded-[7px] ms-2 user-select-none">
                    <i class="opacity-25">null</i>
                </div>
            @endif
        </td>
    @break

    @case('rating')
        <td title="{{ $model->rating }}">
            <div>
                {!! highlightSearch($model->rating ?? '--', $search) !!}/5
                <i class="fas fa-star" style="color: #ffdd00"></i>
            </div>
        </td>
    @break

    @case('client_type')
        <td title="{{ __('main.' . $model->client_type == 'individual' ? 'individual' : 'corporate') }}">
            <span
                class="inline-block text-white bg-{{ $model->client_type == 'individual' ? 'yellow-400' : 'blue-600' }} text-xs font-medium px-2 py-0.5 rounded-[7px] ms-2">
                {!! $model->client_type == 'individual'
                    ? highlightSearch(__('main.individual'), $search)
                    : highlightSearch(__('main.corporate'), $search) !!}
            </span>
        </td>
    @break

    @case('client_status')
        @php
            $color =
                $model->client_status == 'active'
                    ? 'active'
                    : ($model->client_status == 'inactive'
                        ? 'inactive'
                        : 'blacklisted');
        @endphp
        <td title="{{ __('main.' . $model->client_status) }}">
            <span class="inline-block text-white bg-{{ $color }} text-xs font-medium px-2 py-0.5 rounded-[7px] ms-2">
                {!! $model->client_status == 'active'
                    ? highlightSearch(__('main.active'), $search)
                    : ($model->client_status == 'inactive'
                        ? highlightSearch(__('main.inactive'), $search)
                        : highlightSearch(__('main.blacklisted'), $search)) !!}
            </span>
        </td>
    @break

    @case('status')
        <td title="{{ $model->is_active == 1 ? __('main.active') : __('main.inactive') }}">
            <span class="text-{{ $model->is_active == 1 ? 'green' : 'red' }}-600 font-semibold">
                {!! $model->is_active == 1
                    ? highlightSearch(__('main.active'), $search)
                    : highlightSearch(__('main.inactive'), $search) !!}
            </span>
        </td>
    @break

    @case('is_active')
        <td title="{{ $model->is_active == 1 ? __('main.active') : __('main.inactive') }}">
            <span class="text-{{ $model->is_active == 1 ? 'green' : 'red' }}-600 font-semibold">
                {!! $model->is_active == 1
                    ? highlightSearch(__('main.active'), $search)
                    : highlightSearch(__('main.inactive'), $search) !!}
            </span>
        </td>
    @break

    @case('wheelchair_accessible')
        <td title="{{ $model->wheelchair_accessible == 1 ? __('main.active') : __('main.inactive') }}">
            <span class="text-{{ $model->wheelchair_accessible == 1 ? 'green' : 'red' }}-600 font-semibold">
                {!! $model->wheelchair_accessible == 1
                    ? highlightSearch(__('main.active'), $search)
                    : highlightSearch(__('main.inactive'), $search) !!}
            </span>
        </td>
    @break

    @case('free_wifi')
        <td title="{{ $model->free_wifi == 1 ? __('main.active') : __('main.inactive') }}">
            <span class="text-{{ $model->free_wifi == 1 ? 'green' : 'red' }}-600 font-semibold">
                {!! $model->free_wifi == 1
                    ? highlightSearch(__('main.active'), $search)
                    : highlightSearch(__('main.inactive'), $search) !!}
            </span>
        </td>
    @break

    @case('parking')
        <td title="{{ $model->parking == 1 ? __('main.active') : __('main.inactive') }}">
            <span class="text-{{ $model->parking == 1 ? 'green' : 'red' }}-600 font-semibold">
                {!! $model->parking == 1
                    ? highlightSearch(__('main.active'), $search)
                    : highlightSearch(__('main.inactive'), $search) !!}
            </span>
        </td>
    @break

    @case('swimming_pool')
        <td title="{{ $model->swimming_pool == 1 ? __('main.active') : __('main.inactive') }}">
            <span class="text-{{ $model->swimming_pool == 1 ? 'green' : 'red' }}-600 font-semibold">
                {!! $model->swimming_pool == 1
                    ? highlightSearch(__('main.active'), $search)
                    : highlightSearch(__('main.inactive'), $search) !!}
            </span>
        </td>
    @break

    @case('gym')
        <td title="{{ $model->gym == 1 ? __('main.active') : __('main.inactive') }}">
            <span class="text-{{ $model->gym == 1 ? 'green' : 'red' }}-600 font-semibold">
                {!! $model->gym == 1
                    ? highlightSearch(__('main.active'), $search)
                    : highlightSearch(__('main.inactive'), $search) !!}
            </span>
        </td>
    @break

    @case('indoor')
        <td title="{{ $model->indoor == 1 ? __('main.active') : __('main.inactive') }}">
            <span class="text-{{ $model->indoor == 1 ? 'green' : 'red' }}-600 font-semibold">
                {!! $model->indoor == 1
                    ? highlightSearch(__('main.active'), $search)
                    : highlightSearch(__('main.inactive'), $search) !!}
            </span>
        </td>
    @break

    @case('outdoor')
        <td title="{{ $model->outdoor == 1 ? __('main.active') : __('main.inactive') }}">
            <span class="text-{{ $model->outdoor == 1 ? 'green' : 'red' }}-600 font-semibold">
                {!! $model->outdoor == 1
                    ? highlightSearch(__('main.active'), $search)
                    : highlightSearch(__('main.inactive'), $search) !!}
            </span>
        </td>
    @break

    @case('spa')
        <td title="{{ $model->spa == 1 ? __('main.active') : __('main.inactive') }}">
            <span class="text-{{ $model->spa == 1 ? 'green' : 'red' }}-600 font-semibold">
                {!! $model->spa == 1
                    ? highlightSearch(__('main.active'), $search)
                    : highlightSearch(__('main.inactive'), $search) !!}
            </span>
        </td>
    @break

    @case('code')
        <td title="{{ $model->code }}">
            <span class="text-{{ $model->code == getCurrentLocale() ? 'green' : 'red' }}-600 font-semibold">
                {{ $model->code == getCurrentLocale() ? __('main.active') : __('main.inactive') }}
            </span>
        </td>
    @break

    @default
        <td title="_{{ $model->$column }}">{{ limitedText($model->$column ?? '--', 30) }}</td>
@endswitch
