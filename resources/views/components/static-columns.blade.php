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

    @case('first_name')
        <td title="{{ $model->first_name }}">{!! highlightSearch(limitedText($model->first_name ?? '--', 30), $search) !!}</td>
    @break

    @case('last_name')
        <td title="{{ $model->last_name }}">{!! highlightSearch(limitedText($model->last_name ?? '--', 30), $search) !!}</td>
    @break

    @case('name')
        <td title="{{ $model->name }}">{!! highlightSearch(limitedText($model->name ?? '--', 30), $search) !!}</td>
    @break

    @case('email')
        <td title="{{ $model->email }}">{!! highlightSearch(limitedText($model->email ?? '--', 30), $search) !!}</td>
    @break

    @case('personal_email')
        <td title="{{ $model->personal_email }}">{!! highlightSearch(limitedText($model->personal_email ?? '--', 30), $search) !!}</td>
    @break

    @case('email_primary')
        <td title="{{ $model->email_primary }}">{!! highlightSearch(limitedText($model->email_primary ?? '--', 30), $search) !!}</td>
    @break

    @case('work_email')
        <td title="{{ $model->work_email }}">{!! highlightSearch(limitedText($model->work_email ?? '--', 30), $search) !!}</td>
    @break

    @case('secondary_email')
        <td title="{{ $model->secondary_email }}">{!! highlightSearch(limitedText($model->secondary_email ?? '--', 30), $search) !!}</td>
    @break

    @case('whatsapp')
        <td title="{{ $model->whatsapp }}">{!! highlightSearch(limitedText($model->whatsapp ?? '--', 30), $search) !!}</td>
    @break

    @case('phone')
        <td title="{{ $model->phone }}">{!! highlightSearch(limitedText($model->phone ?? '--', 30), $search) !!}</td>
    @break

    @case('mobile')
        <td title="{{ $model->mobile }}">{!! highlightSearch(limitedText($model->mobile ?? '--', 30), $search) !!}</td>
    @break

    @case('primary_phone')
        <td title="{{ $model->primary_phone }}">{!! highlightSearch(limitedText($model->primary_phone ?? '--', 30), $search) !!}</td>
    @break

    @case('secondary_phone')
        <td title="{{ $model->secondary_phone }}">{!! highlightSearch(limitedText($model->secondary_phone ?? '--', 30), $search) !!}</td>
    @break

    @case('home_phone')
        <td title="{{ $model->home_phone }}">{!! highlightSearch(limitedText($model->home_phone ?? '--', 30), $search) !!}</td>
    @break

    @case('work_phone')
        <td title="{{ $model->work_phone }}">{!! highlightSearch(limitedText($model->work_phone ?? '--', 30), $search) !!}</td>
    @break

    @case('work_phone_ext')
        <td title="{{ $model->work_phone_ext }}">{!! highlightSearch(limitedText($model->work_phone_ext ?? '--', 30), $search) !!}</td>
    @break

    @case('fax_number')
        <td title="{{ $model->fax_number }}">{!! highlightSearch(limitedText($model->fax_number ?? '--', 30), $search) !!}</td>
    @break

    @case('birth_date')
        <td title="{{ $model->formatted_birth_date }}">
            {!! highlightSearch(limitedText($model->formatted_birth_date ?? '--', 30), $search) !!}
            <strong class="text-primary">
                {{ $model->formatted_birth_date ? "({$model->age} " . __('main.years') . ')' : '' }}
            </strong>
        </td>
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

    @case('passport_number')
        <td title="{{ $model->passport_number }}">{!! highlightSearch(limitedText($model->passport_number ?? '--', 30), $search) !!}</td>
    @break

    @case('passport_issue_date')
        <td title="{{ $model->passport_issue_date }}">{!! highlightSearch(limitedText($model->passport_issue_date ?? '--', 30), $search) !!}</td>
    @break

    @case('passport_expiry_date')
        <td title="{{ $model->passport_expiry_date }}">{!! highlightSearch(limitedText($model->passport_expiry_date ?? '--', 30), $search) !!}</td>
    @break

    @case('company_name')
        <td title="{{ $model->company_name }}">{!! highlightSearch(limitedText($model->company_name ?? '--', 30), $search) !!}</td>
    @break

    @case('company_phone')
        <td title="{{ $model->company_phone }}">{!! highlightSearch(limitedText($model->company_phone ?? '--', 30), $search) !!}</td>
    @break

    @case('company_email')
        <td title="{{ $model->company_email }}">{!! highlightSearch(limitedText($model->company_email ?? '--', 30), $search) !!}</td>
    @break

    @case('job_title')
        <td title="{{ $model->job_title }}">{!! highlightSearch(limitedText($model->job_title ?? '--', 30), $search) !!}</td>
    @break

    @case('sector')
        <td title="{{ $model->sector }}">{!! highlightSearch(limitedText($model->sector ?? '--', 30), $search) !!}</td>
    @break

    @case('department')
        <td title="{{ $model->department }}">{!! highlightSearch(limitedText($model->department ?? '--', 30), $search) !!}</td>
    @break

    @case('business_type')
        <td title="{{ $model->business_type }}">{!! highlightSearch(limitedText($model->business_type ?? '--', 30), $search) !!}</td>
    @break

    @case('business_registration_number')
        <td title="{{ $model->business_registration_number }}">{!! highlightSearch(limitedText($model->business_registration_number ?? '--', 30), $search) !!}</td>
    @break

    @case('box')
        <td title="{{ $model->box }}">{!! highlightSearch(limitedText($model->box ?? '--', 30), $search) !!}</td>
    @break

    @case('postal_code')
        <td title="{{ $model->postal_code }}">{!! highlightSearch(limitedText($model->postal_code ?? '--', 30), $search) !!}</td>
    @break

    @case('street_address')
        <td title="{{ $model->street_address }}">{!! highlightSearch(limitedText($model->street_address ?? '--', 30), $search) !!}</td>
    @break

    @case('address_line_2')
        <td title="{{ $model->address_line_2 }}">{!! highlightSearch(limitedText($model->address_line_2 ?? '--', 30), $search) !!}</td>
    @break

    @case('website_url')
        <td title="{{ $model->website_url }}"><a href="{{ $model->website_url }}" target="_blank">{!! highlightSearch(limitedText($model->website_url ?? '--', 30), $search) !!}</a>
        </td>
    @break

    @case('linkedin_url')
        <td title="{{ $model->linkedin_url }}"><a href="{{ $model->linkedin_url }}"
                target="_blank">{!! highlightSearch(limitedText($model->linkedin_url ?? '--', 30), $search) !!}</a></td>
    @break

    @case('tax_id')
        <td title="{{ $model->tax_id }}">{!! highlightSearch(limitedText($model->tax_id ?? '--', 30), $search) !!}</td>
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

    @case('nationality')
        <td title="{{ is_string($model->nationality) ? $model->nationality : optional($model->nationality)->name ?? '--' }}">
            {!! highlightSearch(
                limitedText(is_string($model->nationality) ? $model->nationality : optional($model->nationality)->name ?? '--', 30),
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

    @case('timezone')
        <td title="{{ $model->timezone }}">
            <span class="inline-block text-white bg-gray-600 text-xs font-medium px-2 py-0.5 rounded-[7px] ms-2">
                {!! highlightSearch(limitedText(str_replace('_', ' ', $model->timezone) ?? '--', 30), $search) !!}
            </span>
        </td>
    @break

    @case('notes')
        <td title="{{ $model->notes }}">
            <span class="inline-block text-white bg-gray-600 text-xs font-medium px-2 py-0.5 rounded-[7px] ms-2">
                {!! highlightSearch(limitedText($model->notes ?? '--', 30), $search) !!}
            </span>
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

    @case('gender')
        <td title="{{ $model->gender == 'male' ? __('main.male') : __('main.female') }}">
            <span
                class="inline-block bg-{{ $model->gender == 'male' ? 'primary' : 'pink' }} text-white text-xs font-medium px-2 py-0.5 rounded-[7px] ms-2">
                {!! $model->gender == 'male'
                    ? highlightSearch(__('main.male'), $search)
                    : highlightSearch(__('main.female'), $search) !!}
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

    @case('created_by')
        <td title="{{ optional($model)->created_by->name }}">{!! highlightSearch(limitedText(optional($model)->created_by->name ?? '--', 30), $search) !!}</td>
    @break

    @case('updated_by')
        <td title="{{ optional($model)->updated_by->name }}">{!! highlightSearch(limitedText(optional($model)->updated_by->name ?? '--', 30), $search) !!}</td>
    @break

    @default
        <td title="_{{ $model->$column }}">{{ limitedText($model->$column ?? '--', 30) }}</td>
@endswitch
