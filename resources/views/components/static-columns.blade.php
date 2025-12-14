@switch($column)
    @case('id')
        <td title="{{ $model->id }}">{!! highlightSearch($model->id, $search) !!}</td>
    @break

    @case('uuid')
        @if ($settings->app_show_uuid_column != 0)
            <td title="{{ $model->uuid }}">{!! highlightSearch($model->uuid, $search) !!}</td>
        @endif
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

    @case('photo')
        <td title="{{ $model->name }}">
            <div class="relative w-fit">
                <img src="{{ $model->photo && checkExistFile($model->photo) ? asset('storage/' . $model->photo) : asset('metronic/media/avatars/blank.png') }}"
                    alt="{{ $model->name }}" class="rounded-full size-9 shrink-0">
                @if (isset($models) && $models && $models == 'users')
                    <span
                        class="real-active {{ $model->user_status == 'online' ? 'active heartbeat' : '' }} user-heartbeat-{{ $model->id }}"></span>
                @endif
            </div>
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

    @case('name_ar')
        <td title="{{ $model->name_ar }}">{!! highlightSearch(limitedText($model->name_ar ?? '--', 30), $search) !!}</td>
    @break

    @case('email')
        <td title="{{ $model->email }}">{!! highlightSearch(limitedText($model->email ?? '--', 30), $search) !!}</td>
    @break

    @case('description')
        <td title="{{ strip_tags($model->description ?? '--') }}">
            @if (isset($model->description) && !empty($model->description))
                {!! highlightSearch(limitedText(strip_tags($model->description ?? '--'), 30), $search) !!}
            @else
                <div
                    class="inline-block bg-primary/10 text-primary text-xs font-medium px-2 py-0.5 rounded-[7px] ms-2 user-select-none">
                    <i class="opacity-25">null</i>
                </div>
            @endif
        </td>
    @break

    @case('description_ar')
        <td title="{{ strip_tags($model->description_ar ?? '--') }}">
            @if (isset($model->description_ar) && !empty($model->description_ar))
                {!! highlightSearch(limitedText(strip_tags($model->description_ar ?? '--'), 30), $search) !!}
            @else
                <div
                    class="inline-block bg-primary/10 text-primary text-xs font-medium px-2 py-0.5 rounded-[7px] ms-2 user-select-none">
                    <i class="opacity-25">null</i>
                </div>
            @endif
        </td>
    @break

    @case('address')
        <td title="{{ strip_tags($model->address ?? '--') }}">
            @if (isset($model->address) && !empty($model->address))
                {!! highlightSearch(limitedText(strip_tags($model->address ?? '--'), 30), $search) !!}
            @else
                <div
                    class="inline-block bg-primary/10 text-primary text-xs font-medium px-2 py-0.5 rounded-[7px] ms-2 user-select-none">
                    <i class="opacity-25">null</i>
                </div>
            @endif
        </td>
    @break

    @case('address_ar')
        <td title="{{ strip_tags($model->address_ar ?? '--') }}">
            @if (isset($model->address_ar) && !empty($model->address_ar))
                {!! highlightSearch(limitedText(strip_tags($model->address_ar ?? '--'), 30), $search) !!}
            @else
                <div
                    class="inline-block bg-primary/10 text-primary text-xs font-medium px-2 py-0.5 rounded-[7px] ms-2 user-select-none">
                    <i class="opacity-25">null</i>
                </div>
            @endif
        </td>
    @break

    @case('notes')
        <td title="{{ strip_tags($model->notes ?? '--') }}">
            @if (isset($model->notes) && !empty($model->notes))
                {!! highlightSearch(limitedText(strip_tags($model->notes ?? '--'), 30), $search) !!}
            @else
                <div
                    class="inline-block bg-primary/10 text-primary text-xs font-medium px-2 py-0.5 rounded-[7px] ms-2 user-select-none">
                    <i class="opacity-25">null</i>
                </div>
            @endif
        </td>
    @break

    @case('notes_ar')
        <td title="{{ strip_tags($model->notes_ar ?? '--') }}">
            @if (isset($model->notes_ar) && !empty($model->notes_ar))
                {!! highlightSearch(limitedText(strip_tags($model->notes_ar ?? '--'), 30), $search) !!}
            @else
                <div
                    class="inline-block bg-primary/10 text-primary text-xs font-medium px-2 py-0.5 rounded-[7px] ms-2 user-select-none">
                    <i class="opacity-25">null</i>
                </div>
            @endif
        </td>
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

    @case('user_status')
        <td title="{{ $model->user_status }}">
            <span class="{{ $model->user_status }}">
                {!! highlightSearch(limitedText($model->user_status ?? '--', 30), $search) !!}
            </span>
        </td>
    @break

    @case('season_from')
        <td title="{{ $model->formatted_season_from }}">
            <div>{!! highlightSearch(limitedText($model->formatted_season_from ?? '--', 30), $search) !!}</div>
        </td>
    @break

    @case('season_to')
        <td title="{{ $model->formatted_season_to }}">
            <div>{!! highlightSearch(limitedText($model->formatted_season_to ?? '--', 30), $search) !!}</div>
        </td>
    @break

    @case('birth_date')
        <td title="{{ $model->formatted_birth_date }}">
            <div>
                {!! highlightSearch(limitedText($model->formatted_birth_date ?? '--', 30), $search) !!}
            </div>
            @if ($model->formatted_birth_date)
                <div class="text-xs text-primary font-medium mt-1">
                    ({{ $model->age }} {{ __('main.years') }})
                </div>
            @endif
        </td>
    @break

    @case('hire_date')
        <td title="{{ $model->formatted_hire_date }}">
            <div>
                {!! highlightSearch(limitedText($model->formatted_hire_date ?? '--', 30), $search) !!}
            </div>
            @if ($model->duration)
                <div class="text-xs text-primary font-medium mt-1">
                    ({{ $model->duration }})
                </div>
            @endif
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

    @case('user_id')
        <td title="{{ optional($model->user)->name ?? '--' }}">{!! highlightSearch(limitedText(optional($model->user)->name ?? '--', 30), $search) !!}</td>
    @break

    @case('recipient_user_id')
        <td title="{{ optional($model->recipientUser)->name ?? '--' }}">{!! highlightSearch(limitedText(optional($model->recipientUser)->name ?? '--', 30), $search) !!}</td>
    @break

    @case('performer_id')
        <td title="{{ optional($model->performer)->name ?? '--' }}">{!! highlightSearch(limitedText(optional($model->performer)->name ?? '--', 30), $search) !!}</td>
    @break

    @case('target_user_id')
        <td title="{{ optional($model->targetUser)->name ?? '--' }}">{!! highlightSearch(limitedText(optional($model->targetUser)->name ?? '--', 30), $search) !!}</td>
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
        <td title="{{ optional($model)->price }}">{!! highlightSearch(limitedText(optional($model)->price ?? '--', 30), $search) !!} {{ $settings->app_default_currency }}</td>
    @break

    @case('bus_type')
        <td title="{{ optional($model->bus_type)->name ?? '--' }}">{!! highlightSearch(limitedText(optional($model->bus_type)->name ?? '--', 30), $search) !!}</td>
    @break

    @case('currency')
        <td title="{{ optional($model->currency)->code ?? '--' }}">{!! highlightSearch(limitedText(optional($model->currency)->code ?? '--', 30), $search) !!}</td>
    @break

    @case('creator')
        <td title="{{ optional($model->creator)->name ?? '--' }}">{!! highlightSearch(limitedText(optional($model->creator)->name ?? '--', 30), $search) !!}</td>
    @break

    @case('updater')
        <td title="{{ optional($model->updater)->name ?? '--' }}">{!! highlightSearch(limitedText(optional($model->updater)->name ?? '--', 30), $search) !!}</td>
    @break

    @case('accommodation')
        <td title="{{ $model->accommodation->id . ' - ' . optional($model->accommodation)->name ?? '--' }}">
            {!! $model->accommodation->id .
                ' - ' .
                highlightSearch(limitedText(optional($model->accommodation)->name ?? '--', 30), $search) !!}
        </td>
    @break

    @case('season')
        <td title="{{ optional($model->season)->name ?? '--' }}">{!! highlightSearch(limitedText(optional($model->season)->name ?? '--', 30), $search) !!}</td>
    @break

    @case('room')
        <td title="{{ optional($model->room)->name ?? '--' }}">{!! highlightSearch(limitedText(optional($model->room)->name ?? '--', 30), $search) !!}</td>
    @break

    @case('meal')
        <td title="{{ optional($model->meal)->name ?? '--' }}">{!! highlightSearch(limitedText(optional($model->meal)->name ?? '--', 30), $search) !!}</td>
    @break

    @case('seasons')
        @php
            $seasons = $model->seasons()->with('season')->get();
            $roomNames = $seasons->pluck('season.name')->filter()->implode(', ');
        @endphp
        <td title="{{ $roomNames }}">
            @if ($seasons->count() > 0)
                @foreach ($seasons->take(3) as $season)
                    <div class="inline-block bg-primary/10 text-primary text-xs font-medium px-2 py-0.5 rounded-[7px] ms-2">
                        {!! highlightSearch(limitedText($season->season->name ?? '--', 30), $search) !!}
                    </div>
                @endforeach
                @if ($seasons->count() > 3)
                    <div class="inline-block bg-primary/10 text-primary text-xs font-medium px-2 py-0.5 rounded-[7px] ms-2">
                        ...
                    </div>
                @endif
            @else
                <div
                    class="inline-block bg-primary/10 text-primary text-xs font-medium px-2 py-0.5 rounded-[7px] ms-2 user-select-none">
                    <i class="opacity-25">null</i>
                </div>
            @endif
        </td>
    @break

    @case('rooms')
        @php
            $rooms = $model->rooms()->with('room')->get();
            $roomNames = $rooms->pluck('room.name')->filter()->implode(', ');
        @endphp
        <td title="{{ $roomNames }}">
            @if ($rooms->count() > 0)
                @foreach ($rooms->take(3) as $room)
                    <div class="inline-block bg-primary/10 text-primary text-xs font-medium px-2 py-0.5 rounded-[7px] ms-2">
                        {!! highlightSearch(limitedText($room->room->name ?? '--', 30), $search) !!}
                    </div>
                @endforeach
                @if ($rooms->count() > 3)
                    <div class="inline-block bg-primary/10 text-primary text-xs font-medium px-2 py-0.5 rounded-[7px] ms-2">
                        ...
                    </div>
                @endif
            @else
                <div
                    class="inline-block bg-primary/10 text-primary text-xs font-medium px-2 py-0.5 rounded-[7px] ms-2 user-select-none">
                    <i class="opacity-25">null</i>
                </div>
            @endif
        </td>
    @break

    @case('meals')
        @php
            $meals = $model->meals()->with('meal')->get();
            $mealNames = $meals->pluck('meal.name')->filter()->implode(', ');
        @endphp
        <td title="{{ $mealNames }}">
            @if ($meals->count() > 0)
                @foreach ($meals->take(3) as $meal)
                    <div class="inline-block bg-primary/10 text-primary text-xs font-medium px-2 py-0.5 rounded-[7px] ms-2">
                        {!! highlightSearch(limitedText($meal->meal->name ?? '--', 30), $search) !!}
                    </div>
                @endforeach
                @if ($meals->count() > 3)
                    <div class="inline-block bg-primary/10 text-primary text-xs font-medium px-2 py-0.5 rounded-[7px] ms-2">
                        ...
                    </div>
                @endif
            @else
                <div
                    class="inline-block bg-primary/10 text-primary text-xs font-medium px-2 py-0.5 rounded-[7px] ms-2 user-select-none">
                    <i class="opacity-25">null</i>
                </div>
            @endif
        </td>
    @break

    @case('accommodation_type')
        <td title="{{ optional($model->accommodation_type)->name ?? '--' }}">{!! highlightSearch(limitedText(optional($model->accommodation_type)->name ?? '--', 30), $search) !!}</td>
    @break

    @case('timezone')
        <td title="{{ $model->timezone->name }}">
            <span class="inline-block text-white bg-gray-600 text-xs font-medium px-2 py-0.5 rounded-[7px] ms-2">
                {!! highlightSearch(limitedText(str_replace('_', ' ', $model->timezone->name) ?? '--', 30), $search) !!}
            </span>
        </td>
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

    {{-- @case('state_id')
        <td>
            @php $states = $model->states(); @endphp
            @if (count($states))
                @foreach ($states->take(3) as $state)
                    <div class="inline-block bg-primary/10 text-primary text-xs font-medium px-2 py-0.5 rounded-[7px] ms-2">
                        {!! highlightSearch(limitedText($state->name ?? '--', 30), $search) !!}
                    </div>
                @endforeach
                @if ($states->count() > 3)
                    <div class="inline-block bg-primary/10 text-primary text-xs font-medium px-2 py-0.5 rounded-[7px] ms-2">
                        ...
                    </div>
                @endif
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
            @php $cities = $model->cities(); @endphp
            @if (count($cities))
                @foreach ($cities->take(3) as $city)
                    <div class="inline-block bg-primary/10 text-primary text-xs font-medium px-2 py-0.5 rounded-[7px] ms-2">
                        {!! highlightSearch(limitedText($city->name ?? '--', 30), $search) !!}
                    </div>
                @endforeach
                @if ($cities->count() > 3)
                    <div class="inline-block bg-primary/10 text-primary text-xs font-medium px-2 py-0.5 rounded-[7px] ms-2">
                        ...
                    </div>
                @endif
            @else
                <div
                    class="inline-block bg-primary/10 text-primary text-xs font-medium px-2 py-0.5 rounded-[7px] ms-2 user-select-none">
                    <i class="opacity-25">null</i>
                </div>
            @endif
        </td>
    @break --}}
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

    @case('is_global')
        <td title="{{ $model->is_global == 1 ? __('main.yes') : __('main.no') }}">
            @if ($model->is_global == 1)
                <div
                    class="inline-block bg-primary/10 text-primary text-xs font-medium px-2 py-0.5 rounded-[7px] ms-2 user-select-none">
                    {!! highlightSearch(limitedText($model->is_global == 1 ? __('main.yes') : __('main.no'), 30), $search) !!}
                </div>
            @else
                <div
                    class="inline-block bg-danger/10 text-red-600 text-xs font-medium px-2 py-0.5 rounded-[7px] ms-2 user-select-none">
                    {!! highlightSearch(limitedText($model->is_global == 1 ? __('main.yes') : __('main.no'), 30), $search) !!}
                </div>
            @endif
        </td>
    @break

    @case('is_read')
        <td title="{{ $model->is_read == 1 ? __('main.read') : __('main.unread') }}">
            @if ($model->is_read == 1 && $model->read_at)
                <div
                    class="inline-block bg-gray/10 text-gray-600 text-xs font-medium px-2 py-0.5 rounded-[7px] ms-2 user-select-none">
                    {!! highlightSearch(limitedText($model->is_read == 1 ? __('main.readed') : __('main.unreaded'), 30), $search) !!}
                </div>
            @else
                <div
                    class="inline-block bg-primary/10 text-blue-600 text-xs font-medium px-2 py-0.5 rounded-[7px] ms-2 user-select-none">
                    {!! highlightSearch(limitedText($model->is_read == 1 ? __('main.read') : __('main.unread'), 30), $search) !!}
                </div>
            @endif
        </td>
    @break

    @case('message')
        <td class="text-wrap" title="{{ $model->message ?? '--' }}">
            {!! highlightSearch($model->message ?? '--', $search) !!}
        </td>
    @break

    @case('read_at')
        <td title="{{ $model->human_read_at ?? '--' }}">{!! highlightSearch(limitedText($model->human_read_at ?? '--', 30), $search) !!}</td>
    @break

    @case('rating')
        <td title="{{ $model->rating }}">
            <div>
                {!! highlightSearch($model->rating ?? '--', $search) !!}/5
                <i class="fas fa-star" style="color: #ffdd00"></i>
            </div>
        </td>
    @break

    @case('stars')
        <td title="{{ $model->stars }}">
            <div>
                {!! highlightSearch($model->stars ?? '--', $search) !!}/5
                <i class="fas fa-star" style="color: #ffdd00"></i>
            </div>
        </td>
    @break

    {{-- @case('timezone')
        <td title="{{ $model->timezone }}">
            <span class="inline-block text-white bg-gray-600 text-xs font-medium px-2 py-0.5 rounded-[7px] ms-2">
                {!! highlightSearch(limitedText(str_replace('_', ' ', $model->timezone) ?? '--', 30), $search) !!}
            </span>
        </td>
    @break --}}
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

    @case('is_admin')
        <td title="{{ $model->is_admin == 1 ? __('main.yes') : __('main.no') }}">
            <div class="relative">
                <span class="text-{{ $model->is_admin == 1 ? 'green' : 'red' }}-600 font-semibold">
                    {!! $model->is_admin == 1 ? highlightSearch(__('main.yes'), $search) : highlightSearch(__('main.no'), $search) !!}
                </span>
            </div>
        </td>
    @break

    @case('status')
        <td title="{{ $model->is_active == 1 ? __('main.active') : __('main.inactive') }}">
            <div class="relative">
                <span class="text-{{ $model->is_active == 1 ? 'green' : 'red' }}-600 font-semibold">
                    {!! $model->is_active == 1
                        ? highlightSearch(__('main.active'), $search)
                        : highlightSearch(__('main.inactive'), $search) !!}
                </span>
            </div>
        </td>
    @break

    @case('is_supplement')
        <td title="{{ ($model->is_supplement == 1) == 1 ? __('main.yes') : __('main.no') }}" wire:ignore>
            @livewire(
                'toggle-switch',
                [
                    'modelId' => $model->id,
                    'modelType' => get_class($model),
                    'field' => 'is_supplement',
                    'value' => (bool) $model->is_supplement,
                    'table' => $table,
                ],
                key('toggle-' . $model->id . '-is_supplement')
            )
        </td>
    @break

    @case('is_per_person')
        <td title="{{ ($model->is_per_person == 1) == 1 ? __('main.yes') : __('main.no') }}" wire:ignore>
            @livewire(
                'toggle-switch',
                [
                    'modelId' => $model->id,
                    'modelType' => get_class($model),
                    'field' => 'is_per_person',
                    'value' => (bool) $model->is_per_person,
                    'table' => $table,
                ],
                key('toggle-' . $model->id . '-is_per_person')
            )
        </td>
    @break

    @case('is_mandatory')
        <td title="{{ ($model->is_mandatory == 1) == 1 ? __('main.yes') : __('main.no') }}" wire:ignore>
            @livewire(
                'toggle-switch',
                [
                    'modelId' => $model->id,
                    'modelType' => get_class($model),
                    'field' => 'is_mandatory',
                    'value' => (bool) $model->is_mandatory,
                    'table' => $table,
                ],
                key('toggle-' . $model->id . '-is_mandatory')
            )
        </td>
    @break

    @case('is_active')
        <td title="{{ $model->is_active == 1 ? __('main.yes') : __('main.no') }}" wire:ignore>
            @livewire(
                'toggle-switch',
                [
                    'modelId' => $model->id,
                    'modelType' => get_class($model),
                    'field' => 'is_active',
                    'value' => (bool) $model->is_active,
                    'table' => $table,
                ],
                key('toggle-' . $model->id . '-is_active')
            )
        </td>
    @break

    @case('is_verified')
        <td title="{{ $model->is_verified == 1 ? __('main.yes') : __('main.no') }}" wire:ignore>
            @livewire(
                'toggle-switch',
                [
                    'modelId' => $model->id,
                    'modelType' => get_class($model),
                    'field' => 'is_verified',
                    'value' => (bool) $model->is_verified,
                    'table' => $table,
                ],
                key('toggle-' . $model->id . '-is_verified')
            )
        </td>
    @break

    @case('is_independent')
        <td title="{{ $model->is_independent == 1 ? __('main.yes') : __('main.no') }}" wire:ignore>
            @livewire(
                'toggle-switch',
                [
                    'modelId' => $model->id,
                    'modelType' => get_class($model),
                    'field' => 'is_independent',
                    'value' => (bool) $model->is_independent,
                    'table' => $table,
                ],
                key('toggle-' . $model->id . '-is_independent')
            )
        </td>
    @break

    @case('is_developed')
        <td title="{{ $model->is_developed == 1 ? __('main.yes') : __('main.no') }}" wire:ignore>
            @livewire(
                'toggle-switch',
                [
                    'modelId' => $model->id,
                    'modelType' => get_class($model),
                    'field' => 'is_developed',
                    'value' => (bool) $model->is_developed,
                    'table' => $table,
                ],
                key('toggle-' . $model->id . '-is_developed')
            )
        </td>
    @break

    @case('is_landlocked')
        <td title="{{ $model->is_landlocked == 1 ? __('main.yes') : __('main.no') }}" wire:ignore>
            @livewire(
                'toggle-switch',
                [
                    'modelId' => $model->id,
                    'modelType' => get_class($model),
                    'field' => 'is_landlocked',
                    'value' => (bool) $model->is_landlocked,
                    'table' => $table,
                ],
                key('toggle-' . $model->id . '-is_landlocked')
            )
        </td>
    @break

    @case('is_included')
        <td title="{{ $model->is_included == 1 ? __('main.yes') : __('main.no') }}" wire:ignore>
            @livewire(
                'toggle-switch',
                [
                    'modelId' => $model->id,
                    'modelType' => get_class($model),
                    'field' => 'is_included',
                    'value' => (bool) $model->is_included,
                    'table' => $table,
                ],
                key('toggle-' . $model->id . '-is_included')
            )
        </td>
    @break

    @case('wheelchair_accessible')
        <td title="{{ $model->wheelchair_accessible == 1 ? __('main.yes') : __('main.no') }}" wire:ignore>
            @livewire(
                'toggle-switch',
                [
                    'modelId' => $model->id,
                    'modelType' => get_class($model),
                    'field' => 'wheelchair_accessible',
                    'value' => (bool) $model->wheelchair_accessible,
                    'table' => $table,
                ],
                key('toggle-' . $model->id . '-wheelchair_accessible')
            )
        </td>
    @break

    @case('free_wifi')
        <td title="{{ $model->free_wifi == 1 ? __('main.yes') : __('main.no') }}" wire:ignore>
            @livewire(
                'toggle-switch',
                [
                    'modelId' => $model->id,
                    'modelType' => get_class($model),
                    'field' => 'free_wifi',
                    'value' => (bool) $model->free_wifi,
                    'table' => $table,
                ],
                key('toggle-' . $model->id . '-free_wifi')
            )
        </td>
    @break

    @case('parking')
        <td title="{{ $model->parking == 1 ? __('main.yes') : __('main.no') }}" wire:ignore>
            @livewire(
                'toggle-switch',
                [
                    'modelId' => $model->id,
                    'modelType' => get_class($model),
                    'field' => 'parking',
                    'value' => (bool) $model->parking,
                    'table' => $table,
                ],
                key('toggle-' . $model->id . '-parking')
            )
        </td>
    @break

    @case('swimming_pool')
        <td title="{{ $model->swimming_pool == 1 ? __('main.yes') : __('main.no') }}" wire:ignore>
            @livewire(
                'toggle-switch',
                [
                    'modelId' => $model->id,
                    'modelType' => get_class($model),
                    'field' => 'swimming_pool',
                    'value' => (bool) $model->swimming_pool,
                    'table' => $table,
                ],
                key('toggle-' . $model->id . '-swimming_pool')
            )
        </td>
    @break

    @case('gym')
        <td title="{{ $model->gym == 1 ? __('main.yes') : __('main.no') }}" wire:ignore>
            @livewire(
                'toggle-switch',
                [
                    'modelId' => $model->id,
                    'modelType' => get_class($model),
                    'field' => 'gym',
                    'value' => (bool) $model->gym,
                    'table' => $table,
                ],
                key('toggle-' . $model->id . '-gym')
            )
        </td>
    @break

    @case('indoor')
        <td title="{{ $model->indoor == 1 ? __('main.yes') : __('main.no') }}" wire:ignore>
            @livewire(
                'toggle-switch',
                [
                    'modelId' => $model->id,
                    'modelType' => get_class($model),
                    'field' => 'indoor',
                    'value' => (bool) $model->indoor,
                    'table' => $table,
                ],
                key('toggle-' . $model->id . '-indoor')
            )
        </td>
    @break

    @case('outdoor')
        <td title="{{ $model->outdoor == 1 ? __('main.yes') : __('main.no') }}" wire:ignore>
            @livewire(
                'toggle-switch',
                [
                    'modelId' => $model->id,
                    'modelType' => get_class($model),
                    'field' => 'outdoor',
                    'value' => (bool) $model->outdoor,
                    'table' => $table,
                ],
                key('toggle-' . $model->id . '-outdoor')
            )
        </td>
    @break

    @case('spa')
        <td title="{{ $model->spa == 1 ? __('main.yes') : __('main.no') }}" wire:ignore>
            @livewire(
                'toggle-switch',
                [
                    'modelId' => $model->id,
                    'modelType' => get_class($model),
                    'field' => 'spa',
                    'value' => (bool) $model->spa,
                    'table' => $table,
                ],
                key('toggle-' . $model->id . '-spa')
            )
        </td>
    @break

    w
    @case('code')
        <td title="{{ $model->code }}">
            <span class="text-{{ $model->code == getCurrentLocale() ? 'green' : 'red' }}-600 font-semibold">
                {{ $model->code == getCurrentLocale() ? __('main.active') : __('main.inactive') }}
            </span>
        </td>
    @break

    @case('created_by')
        <td title="{{ optional($model->created_by)->name ?: '' }}">{!! highlightSearch(limitedText(optional($model->created_by)->name ?? '--', 30), $search) !!}</td>
    @break

    @case('updated_by')
        <td title="{{ optional($model->updated_by)->name ?: '' }}">{!! highlightSearch(limitedText(optional($model->updated_by)->name ?? '--', 30), $search) !!}</td>
    @break

    @default
        <td title="{{ $model->$column }}">{{ limitedText($model->$column ?? '--', 30) }}</td>
@endswitch
