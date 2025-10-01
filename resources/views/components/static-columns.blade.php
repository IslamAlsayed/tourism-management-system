@switch($column)
    @case('id')
        <td>{!! highlightSearch($model->id, $search) !!}</td>
    @break

    @case('user')
        <td>
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

    @case('photo')
        <td>
            <div class="flex items-center gap-2.5">
                <img src="{{ $model->photo ? asset('storage/' . $model->photo) : asset('metronic/media/avatars/blank.png') }}"
                    alt="{{ $model->name }}" class="rounded-full size-9 shrink-0">
            </div>
        </td>
    @break

    @case('name')
        <td>{!! highlightSearch($model->name ?? '--', $search) !!}</td>
    @break

    @case('email')
        <td>{!! highlightSearch($model->email ?? '--', $search) !!}</td>
    @break

    @case('phone')
        <td>{!! highlightSearch($model->phone ?? '--', $search) !!}</td>
    @break

    @case('mobile')
        <td>{!! highlightSearch($model->mobile ?? '--', $search) !!}</td>
    @break

    @case('position')
        <td>{!! highlightSearch($model->position ?? '--', $search) !!}</td>
    @break

    @case('created_at')
        <td>{!! highlightSearch($model->created_at?->format('Y-m-d') ?? '--', $search) !!}</td>
    @break

    @case('code')
        <td>{!! highlightSearch($model->code ?? '--', $search) !!}</td>
    @break

    @case('symbol')
        <td>{!! highlightSearch($model->symbol ?? '--', $search) !!}</td>
    @break

    @case('currency')
        <td>{!! highlightSearch($model->currency->code ?? '--', $search) !!}</td>
    @break

    @case('company')
        <td>{!! highlightSearch($model->company->name ?? '--', $search) !!}</td>
    @break

    @case('country')
        <td>{!! highlightSearch($model->country->name ?? '--', $search) !!}</td>
    @break

    @case('state')
        <td>{!! highlightSearch($model->state->name ?? '--', $search) !!}</td>
    @break

    @case('city')
        <td>{!! highlightSearch($model->city->name ?? '--', $search) !!}</td>
    @break

    @case('region')
        <td>{!! highlightSearch($model->region->name ?? '--', $search) !!}</td>
    @break

    @case('subregion')
        <td>{!! highlightSearch($model->subregion->name ?? '--', $search) !!}</td>
    @break

    @case('tour_guide')
        <td>{!! highlightSearch($model->tour_guide->name ?? '--', $search) !!}</td>
    @break

    @case('rating')
        <td>
            <div>
                {{$model->rating}}/5
                <i class="fas fa-star" style="color: #ffdd00"></i>
                {!! highlightSearch($model->rating ?? '--', $search) !!}
            </div>
        </td>
    @break

    @case('status')
        <td>
            <span class="text-{{ $model->is_active == 1 ? 'green' : 'red' }}-600 font-semibold">
                {!! $model->is_active == 1
                    ? highlightSearch(__('main.active'), $search)
                    : highlightSearch(__('main.inactive'), $search) !!}
            </span>
        </td>
    @break

    @case('is_active')
        <td>
            <span class="text-{{ $model->is_active == 1 ? 'green' : 'red' }}-600 font-semibold">
                {!! $model->is_active == 1
                    ? highlightSearch(__('main.active'), $search)
                    : highlightSearch(__('main.inactive'), $search) !!}
            </span>
        </td>
    @break

    @case('wheelchair_accessible')
        <td>
            <span class="text-{{ $model->wheelchair_accessible == 1 ? 'green' : 'red' }}-600 font-semibold">
                {!! $model->wheelchair_accessible == 1
                    ? highlightSearch(__('main.active'), $search)
                    : highlightSearch(__('main.inactive'), $search) !!}
            </span>
        </td>
    @break

    @case('free_wifi')
        <td>
            <span class="text-{{ $model->free_wifi == 1 ? 'green' : 'red' }}-600 font-semibold">
                {!! $model->free_wifi == 1
                    ? highlightSearch(__('main.active'), $search)
                    : highlightSearch(__('main.inactive'), $search) !!}
            </span>
        </td>
    @break

    @case('parking')
        <td>
            <span class="text-{{ $model->parking == 1 ? 'green' : 'red' }}-600 font-semibold">
                {!! $model->parking == 1
                    ? highlightSearch(__('main.active'), $search)
                    : highlightSearch(__('main.inactive'), $search) !!}
            </span>
        </td>
    @break

    @case('swimming_pool')
        <td>
            <span class="text-{{ $model->swimming_pool == 1 ? 'green' : 'red' }}-600 font-semibold">
                {!! $model->swimming_pool == 1
                    ? highlightSearch(__('main.active'), $search)
                    : highlightSearch(__('main.inactive'), $search) !!}
            </span>
        </td>
    @break

    @case('gym')
        <td>
            <span class="text-{{ $model->gym == 1 ? 'green' : 'red' }}-600 font-semibold">
                {!! $model->gym == 1
                    ? highlightSearch(__('main.active'), $search)
                    : highlightSearch(__('main.inactive'), $search) !!}
            </span>
        </td>
    @break

    @case('indoor')
        <td>
            <span class="text-{{ $model->indoor == 1 ? 'green' : 'red' }}-600 font-semibold">
                {!! $model->indoor == 1
                    ? highlightSearch(__('main.active'), $search)
                    : highlightSearch(__('main.inactive'), $search) !!}
            </span>
        </td>
    @break

    @case('outdoor')
        <td>
            <span class="text-{{ $model->outdoor == 1 ? 'green' : 'red' }}-600 font-semibold">
                {!! $model->outdoor == 1
                    ? highlightSearch(__('main.active'), $search)
                    : highlightSearch(__('main.inactive'), $search) !!}
            </span>
        </td>
    @break

    @case('spa')
        <td>
            <span class="text-{{ $model->spa == 1 ? 'green' : 'red' }}-600 font-semibold">
                {!! $model->spa == 1
                    ? highlightSearch(__('main.active'), $search)
                    : highlightSearch(__('main.inactive'), $search) !!}
            </span>
        </td>
    @break

    @case('code')
        <td>
            <span class="text-{{ $model->code == getCurrentLocale() ? 'green' : 'red' }}-600 font-semibold">
                {{ $model->code == getCurrentLocale() ? __('main.active') : __('main.inactive') }}
            </span>
        </td>
    @break

    @default
        <td>{{ $model->$column ?? '--' }}</td>
@endswitch
