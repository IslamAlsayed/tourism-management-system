@extends('layouts.master')

@section('title', __('main.add_type', ['type' => __('main.tour-guide-type')]))

@section('content')
<div class="kt-container-fixed">
    <div class="flex flex-wrap items-center lg:items-end justify-between gap-4 pb-6">
        <div class="flex flex-col justify-center gap-2">
            <h1 class="text-xl font-medium leading-none text-mono">
                {{ __('main.add_type', ['type' => __('main.tour-guide-type')]) }}
            </h1>
            <div class="flex items-center gap-2 text-sm font-normal text-secondary-foreground">
                {{ __('main.add_type_description', ['type' => __('main.tour-guide-type')]) }}
            </div>
        </div>
        <div class="flex items-center gap-2.5">
            <a href="{{ route('tour-guides-types.index') }}" class="kt-btn kt-btn-outline">
                {{ __('main.back_to_types', ['type' => __('main.tour-guide-types')]) }}
            </a>
        </div>
    </div>
</div>

<div class="kt-container-fixed">
    <div class="grid gap-4 lg:gap-6">
        <!-- Tour Guides Types Form -->
        <div class="kt-card">
            <div class="kt-card-header">
                <h3 class="kt-card-title">{{ __('main.type_information', ['type' => __('main.tour-guide-type')]) }}</h3>
            </div>
            <div class="kt-card-body">
                <form method="POST" action="{{ route('tour-guides-types.store') }}" enctype="multipart/form-data" class="space-y-6 p-4">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-4">
                        <!-- Type -->
                        <div class="">
                            <label for="type" class="kt-label required mb-2">{{ __('main.type') }}</label>
                            <input type="text" name="type" id="type" class="kt-input h-[45px]" required value="{{ old('type') }}">
                            @error('type')
                            <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Price -->
                        <div class="">
                            <label for="price" class="kt-label required mb-2">{{ __('main.price') }}</label>
                            <input type="text" name="price" min="1" id="price" class="kt-input h-[45px]" required value="{{ old('price') }}">
                            @error('price')
                            <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Currency -->
                        <div class="">
                            <label for="currency_id" class="kt-label required mb-2 flex items-center justify-between">
                                {{ __('main.currency') }}
                                <a href="{{ route('currencies.create') }}" class="text-blue-600 text-2sm">
                                    {{ __('main.add') }}
                                </a>
                            </label>
                            <select name="currency_id" id="currency_id" class="kt-select h-[45px]" special-search>
                                <option value="">--</option>
                                @foreach ($currencies as $currency)
                                <option value="{{ $currency->id }}" {{ old('currency_id')==$currency->id ? 'selected' : '' }}>
                                    {{ $currency->code }} - {{ $currency->name }}
                                </option>
                                @endforeach
                            </select>
                            @error('currency_id')
                            <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Region -->
                        <div class="">
                            <label for="region_id" class="kt-label required mb-2 flex items-center justify-between">
                                {{ __('main.region') }}
                                <a href="{{ route('regions.create') }}" class="text-blue-600 text-2sm">
                                    {{ __('main.add') }}
                                </a>
                            </label>
                            <select name="region_id" id="region_id" class="kt-select h-[45px]" special-search>
                                <option value="">--</option>
                                @foreach ($regions as $region)
                                <option value="{{ $region->id }}" {{ old('region_id')==$region->id ? 'selected' : '' }}>
                                    {{ $region->name }}
                                </option>
                                @endforeach
                            </select>
                            @error('region_id')
                            <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Subregion -->
                        <div class="loading">
                            <label for="subregion_id" class="kt-label required mb-2 flex items-center justify-between">
                                <div>
                                    {{ __('main.subregion') }}
                                    <i id="subregion_id-loader" class="i-loader fas fa-refresh fa-spin text-primary"></i>
                                    <span class="text-red-600 text-sm span-info show" id="subregion_id-info">
                                        (You must select region first)
                                    </span>
                                </div>
                                <a href="{{ route('subregions.create') }}" class="text-blue-600 text-2sm">
                                    {{ __('main.add') }}
                                </a>
                            </label>
                            <select name="subregion_id" id="subregion_id" class="kt-select h-[45px]" special-search>
                                <option value="">--</option>
                                @foreach ($subregions as $subregion)
                                <option value="{{ $subregion->id }}" {{ old('subregion_id')==$subregion->id ? 'selected' : '' }}>
                                    {{ $subregion->name }}
                                </option>
                                @endforeach
                            </select>
                            @error('subregion_id')
                            <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Country -->
                        <div class="loading">
                            <label for="country_id" class="kt-label required mb-2 flex items-center justify-between">
                                <div>
                                    {{ __('main.country') }}
                                    <i id="country_id-loader" class="i-loader fas fa-refresh fa-spin text-primary"></i>
                                    <span class="text-red-600 text-sm span-info show" id="country_id-info">
                                        (You must select subregion first)
                                    </span>
                                </div>
                                <a href="{{ route('countries.create') }}" class="text-blue-600 text-2sm">
                                    {{ __('main.add') }}
                                </a>
                            </label>
                            <select name="country_id" id="country_id" class="kt-select h-[45px]" special-search>
                                <option value="">--</option>
                                @foreach ($countries as $country)
                                <option value="{{ $country->id }}" {{ old('country_id')==$country->id ? 'selected' : '' }}>{{ $country->name }}
                                </option>
                                @endforeach
                            </select>
                            @error('country_id')
                            <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- State --}}
                        <div class="loading">
                            <label for="all_states" class="kt-label required mb-2 flex items-center justify-between">
                                <div class="flex items-center gap-2">
                                    <div class="flex items-center gap-2">
                                        <input type="hidden" name="all_states" value="0">
                                        <input type="checkbox" name="all_states" id="all_states" class="kt-checkbox" style="width: 17px; height: 17px;" value="1" {{ old('all_states') ? 'checked' : '' }}>
                                        {{ __('main.all_types', ['types' => __('main.states')]) }}
                                        <i id="state_id-loader" class="i-loader fas fa-refresh fa-spin text-primary"></i>
                                    </div>
                                    <span class="text-red-600 text-sm span-info show" id="state_id-info">
                                        (You must select country first)
                                    </span>
                                </div>
                                <a href="{{ route('states.create') }}" class="text-blue-600 text-2sm">
                                    {{ __('main.add') }}
                                </a>
                            </label>
                            <select name="state_id" id="state_id" class="kt-select h-[45px]" special-search disabled>
                                <option value="">--</option>
                                @foreach ($states as $state)
                                <option value="{{ $state->id }}" {{ old('state_id')==$state->id ? 'selected' : '' }}>
                                    {{ $state->name }}
                                </option>
                                @endforeach
                            </select>
                            @error('state_id')
                            <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- City -->
                        <div class="loading">
                            <label for="all_cities" class="kt-label required mb-2 flex items-center justify-between">
                                <div class="flex items-center justify-between gap-1">
                                    <div class="flex items-center justify-between gap-1">
                                        <input type="hidden" name="all_cities" value="0">
                                        <input type="checkbox" name="all_cities" id="all_cities" class="kt-checkbox" style="width: 17px; height: 17px;" value="1" {{ old('all_cities') ? 'checked' : '' }}>
                                        {{ __('main.all_types', ['types' => __('main.cities')]) }}
                                        <i id="city_id-loader" class="i-loader fas fa-refresh fa-spin text-primary"></i>
                                    </div>
                                    <span class="text-red-600 text-sm span-info show" id="city_id-info">
                                        (You must select state first)
                                    </span>
                                </div>

                                <a href="{{ route('cities.create') }}" class="text-blue-600 text-2sm">
                                    {{ __('main.add') }}
                                </a>
                            </label>
                            <select name="city_id" id="city_id" class="kt-select h-[45px]" disabled special-search>
                                <option value="">--</option>
                                @foreach ($cities as $city)
                                <option value="{{ $city->id }}" {{ old('city_id')==$city->id ? 'selected' : '' }}>
                                    {{ $city->name }}
                                </option>
                                @endforeach
                            </select>
                            @error('city_id')
                            <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Submit Buttons -->
                    <div class="flex items-center gap-4">
                        <button type="submit" class="kt-btn kt-btn-primary">
                            <i class="ki-filled ki-check text-sm me-2"></i>
                            {{ __('main.save_type', ['type' => __('main.tour-guide-type')]) }}
                        </button>
                        <button type="submit" name="save_and_add" value="1" class="kt-btn kt-btn-outline kt-btn-outline-primary">
                            <i class="ki-filled ki-plus text-sm me-2"></i>
                            {{ __('main.save_and_add_another') }}
                        </button>
                        <a href="{{ route('tour-guides-types.index') }}" class="kt-btn kt-btn-outline">
                            {{ __('main.cancel') }}
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <!-- Geographic Info -->
        <div class="kt-card">
            <div class="kt-card-header">
                <h3 class="kt-card-title">{{ __('main.geographic_info') }}</h3>
            </div>
            <div class="kt-card-body p-2">
                <div class="space-y-3">
                    <div class="flex items-center gap-3">
                        <div class="bg-primary-light rounded-full p-2">
                            <i class="ki-filled ki-geolocation text-primary"></i>
                        </div>
                        <div>
                            <div class="font-semibold">{{ __('main.geographic_coordinates') }}</div>
                            <div class="text-sm text-secondary-foreground">{{ __('main.coordinates_hint') }}</div>
                        </div>
                    </div>

                    <div class="flex items-center gap-3">
                        <div class="bg-warning-light rounded-full p-2">
                            <i class="ki-filled ki-flag text-warning"></i>
                        </div>
                        <div>
                            <div class="font-semibold">
                                {{ __('main.type_selection', ['type' => __('main.gender')]) }}</div>
                            <div class="text-sm text-secondary-foreground">
                                {{ __('main.must_select_type1_before_creating_type2', ['type1' => __('main.gender'), 'type2' => __('main.tour-guide-type')]) }}
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center gap-3">
                        <div class="bg-warning-light rounded-full p-2">
                            <i class="ki-filled ki-flag text-warning"></i>
                        </div>
                        <div>
                            <div class="font-semibold">
                                {{ __('main.type_selection', ['type' => __('main.country')]) }}</div>
                            <div class="text-sm text-secondary-foreground">
                                {{ __('main.must_select_type1_before_creating_type2', ['type1' => __('main.country'), 'type2' => __('main.tour-guide-type')]) }}
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center gap-3">
                        <div class="bg-warning-light rounded-full p-2">
                            <i class="ki-filled ki-flag text-warning"></i>
                        </div>
                        <div>
                            <div class="font-semibold">
                                {{ __('main.type_selection', ['type' => __('main.currency')]) }}</div>
                            <div class="text-sm text-secondary-foreground">
                                {{ __('main.must_select_type1_before_creating_type2', ['type1' => __('main.currency'), 'type2' => __('main.tour-guide-type')]) }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener("DOMContentLoaded", () => {
        filterByForeignId("region_id", "subregion", "subregion_id");
        filterByForeignId("subregion_id", "country", "country_id");
        filterByForeignId("country_id", "state", "state_id");
        filterByForeignId("state_id", "city", "city_id");
    });

    document.addEventListener("DOMContentLoaded", () => {
        const countrySelect = document.querySelector("[data-for='country_id'] .tag-input");
        const stateSelect = document.querySelector("[data-for='state_id'] .tag-input");
        const citySelect = document.querySelector("[data-for='city_id'] .tag-input");

        const allStates = document.getElementById("all_states");
        const allCities = document.getElementById("all_cities");

        // 🔁 دالة لتحديث المدن
        const updateCities = () => {
            const isallState = allStates?.checked;
            const selectedState = stateSelect?.dataset.id || null;
            const countryId = countrySelect?.dataset.id || null;

            console.log("🌍 تحديث المدن:", {
                isallState,
                selectedState,
                countryId
            });

            const citySelectEl = document.getElementById("city_id");
            if (!citySelectEl) return;

            citySelectEl.innerHTML = '<option value="">--</option>';
            citySelectEl.disabled = true;

            // ✅ لو مختار "كل المحافظات" → جلب المدن حسب الدولة
            if (isallState && countryId) {
                console.log("✅ كل المحافظات مفعلة — جلب المدن حسب الدولة:", countryId);
                filterByForeignId("country_id", "city", "city_id", countryId);
                return;
            }

            // ✅ لو مختار محافظة معينة فقط
            if (selectedState) {
                console.log("📍 محافظة واحدة مختارة — جلب المدن:", selectedState);
                filterByForeignId("state_id", "city", "city_id", selectedState);
                return;
            }

            console.log("⚠️ لا توجد دولة أو محافظة محددة بعد");
        };

        // 🟩 عند تغيير الدولة
        countrySelect?.addEventListener("updatedSelect", (e) => {
            const countryId = e.detail.value;
            console.log("🟩 الدولة تغيرت:", countryId);

            filterByForeignId("country_id", "state", "state_id", countryId);
            setTimeout(updateCities, 500);
        });

        // 🟦 عند تغيير المحافظة
        stateSelect?.addEventListener("updatedSelect", (e) => {
            console.log("🟦 المحافظة تغيرت:", e.detail.value);
            updateCities();
        });

        // 🟧 عند تفعيل "كل المحافظات"
        allStates?.addEventListener("change", () => {
            const checked = allStates.checked;
            console.log("🟧 all_states:", checked);

            const stateSelectEl = document.getElementById("state_id");
            stateSelectEl.disabled = checked;

            if (checked) {
                stateSelectEl.value = "";
                stateSelectEl.innerHTML = '<option value="">--</option>';
            } else {
                const countryId = countrySelect?.dataset.id;
                if (countryId) {
                    filterByForeignId("country_id", "state", "state_id", countryId);
                }
            }

            updateCities();
        });

        // 🟨 عند تفعيل "كل المدن"
        allCities?.addEventListener("change", () => {
            const checked = allCities.checked;
            console.log("🟨 all_cities:", checked);

            citySelect.disabled = checked;

            if (checked) {
                citySelect.value = "";
                citySelect.innerHTML = '<option value="">--</option>';
            } else {
                updateCities();
            }
        });
    });
</script>
@endpush


{{-- @push('scripts')
<script>
    // document.addEventListener("DOMContentLoaded", () => {
    // const stateSelect = document.getElementById("state_id");
    // const citySelect = document.getElementById("city_id");
    // const allStates = document.getElementById("all_states");
    // const allCities = document.getElementById("all_cities");

    // // 🔁 دالة لتحديث المدن حسب المنطق الحالي
    // const updateCities = () => {
    // const isallState = allStates?.checked;
    // const selectedState = stateSelect?.value;
    // const countryId = document.getElementById("country_id")?.value;

    // // لو محدد "كل المحافظات" → نجيب كل المدن
    // if (isallState) {
    // filterByForeignId("country_id", "city", "city_id"); // country فقط
    // return;
    // }

    // // لو محدد محافظة واحدة → نجيب مدنها
    // if (selectedState) {
    // filterByForeignId("state_id", "city", "city_id");
    // } else if (countryId) {
    // // fallback في حالة مفيش محافظة مختارة
    // filterByForeignId("country_id", "city", "city_id");
    // }
    // };

    // // ✅ عند تغيير الدولة → تحديث المحافظات والمدن
    // document.getElementById("country_id")?.addEventListener("change", () => {
    // filterByForeignId("country_id", "state", "state_id");
    // updateCities();
    // });

    // // ✅ عند تغيير المحافظة → تحديث المدن
    // stateSelect?.addEventListener("change", updateCities);

    // // ✅ عند تغيير all_states → تحديث المدن تبعًا للحالة الجديدة
    // allStates?.addEventListener("change", () => {
    // if (allStates.checked) {
    // // كل المحافظات → تحديث المدن بناءً على كل المحافظات
    // stateSelect.disabled = true;
    // stateSelect.value = "";
    // updateCities();
    // } else {
    // // محافظة محددة → فعل الاختيار
    // stateSelect.disabled = false;
    // }
    // });

    // // ✅ عند تغيير all_cities → تعطيل أو تفعيل select
    // allCities?.addEventListener("change", () => {
    // const checked = allCities.checked;
    // citySelect.disabled = checked;
    // if (checked) {
    // citySelect.value = "";
    // } else {
    // updateCities();
    // }
    // });
    // });


    // document.addEventListener("DOMContentLoaded", () => {
    // const hierarchy = ["state", "city"];

    // hierarchy.forEach((element, index) => {
    // const multiCheckbox = document.getElementById(`multi_${element}s`);
    // const select = document.getElementById(`${element}_id`);

    // if (!multiCheckbox || !select) return;

    // // ✅ في أول تحميل
    // select.disabled = multiCheckbox.checked;

    // // ✅ عند التغيير
    // multiCheckbox.addEventListener("change", () => {
    // const checked = multiCheckbox.checked;
    // select.disabled = checked;

    // // لو المستخدم فعّل "كل العناصر" → نفرغ الاختيارات التابعة
    // if (checked) {
    // select.value = "";
    // select.innerHTML = '<option value="">--</option>';

    // // نحذف كل العناصر اللي بعدها في التسلسل
    // for (let i = index + 1; i < hierarchy.length; i++) { // const
    nextSelect = document.getElementById(`${hierarchy[i]}_id`); // if (nextSelect) { //
    nextSelect.innerHTML = '<option value="">--</option>'; // nextSelect.disabled=true; // } // } // } else { //
    // ✅ لما يلغي التحديد → نعيد تحميل البيانات بناءً على الأب // const parent=hierarchy[index - 1]; // const
    parentSelect = document.getElementById(`${parent}_id`); // if (parentSelect && parentSelect.value) { //
    filterByForeignId(`${parent}_id`, element, `${element}_id`); // } // } // }); // }); // }); {{-- @push('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const regionWrapper = document.querySelector(`[data-for="region_id"]`);
        // 1️⃣ Region -> Subregion
        filterByForeignId("region_id", "subregion", "subregion_id");

            // ✅ نراقب بناء الـ subregion بعد ما SpecialSearch تجهزه
            const subregionObserver = new MutationObserver(() => {
                const subregionWrapper = document.querySelector(`[data-for="subregion_id"]`);
        const subregionSelect = document.getElementById("subregion_id");

        if (subregionWrapper && subregionSelect) {
            subregionWrapper.addEventListener('click', () => {
                setTimeout(() => {
                    console.log(
                        "✅ Subregion ready — binding country fetch..."
                    );
                    filterByForeignId("subregion_id", "country",
                        "country_id");
                }, 300);

                subregionObserver.disconnect();
            });
                }
            });

        subregionObserver.observe(document.body, {
            childList: true,
        subtree: true
            });

            // ✅ نراقب بناء الـ country بعد ما تتجهز
            const countryObserver = new MutationObserver(() => {
                const countryWrapper = document.querySelector(`[data-for="country_id"]`);
        const countrySelect = document.getElementById("country_id");

        if (countryWrapper && countrySelect) {
            countryWrapper.addEventListener('click', () => {
                setTimeout(() => {
                    console.log(
                        "✅ Country ready — binding state fetch...");
                    filterByForeignId("country_id", "state",
                        "state_id");
                }, 300);

                countryObserver.disconnect();
            });
                }
            });

        countryObserver.observe(document.body, {
            childList: true,
        subtree: true
            });

            // ✅ نراقب بناء الـ state بعد ما تتجهز
            const stateObserver = new MutationObserver(() => {
                const stateWrapper = document.querySelector(`[data-for="state_id"]`);
        const stateSelect = document.getElementById("state_id");

        if (stateWrapper && stateSelect) {
            stateWrapper.addEventListener('click', () => {
                setTimeout(() => {
                    console.log(
                        "✅ State ready — binding city fetch...");
                    filterByForeignId("state_id", "city", "city_id");
                }, 300);

                stateObserver.disconnect();
            });
                }
            });

        stateObserver.observe(document.body, {
            childList: true,
        subtree: true
            });
            // });
        });
</script>
@endpush --}}