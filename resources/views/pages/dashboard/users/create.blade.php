@extends('layouts.master')

@section('title', 'إضافة مستخدم جديد')

@section('content')
    <div class="kt-container-fixed">
        <div class="flex flex-wrap items-center lg:items-end justify-between gap-5 pb-7.5">
            <div class="flex flex-col justify-center gap-2">
                <h1 class="text-xl font-medium leading-none text-mono">
                    إضافة مستخدم جديد
                </h1>
                <div class="flex items-center gap-2 text-sm font-normal text-secondary-foreground">
                    إنشاء حساب مستخدم جديد في النظام
                </div>
            </div>
            <div class="flex items-center gap-2.5">
                <a href="{{ route('users.index') }}" class="kt-btn kt-btn-outline">
                    العودة للمستخدمين
                </a>
            </div>
        </div>
    </div>

    <div class="kt-container-fixed">
        <div class="grid gap-5 lg:gap-7.5">
            <!-- User Form -->
            <div class="kt-card">
                <div class="kt-card-header">
                    <h3 class="kt-card-title">معلومات المستخدم الأساسية</h3>
                </div>
                <div class="kt-card-body">
                    <form method="POST" action="{{ route('users.store') }}" enctype="multipart/form-data" class="space-y-6">
                        @csrf

                        <!-- Profile Photo -->
                        <div class="text-center">
                            <div class="relative inline-block">
                                <div class="w-24 h-24 rounded-full bg-secondary-light border-4 border-white shadow-lg mx-auto mb-4 overflow-hidden">
                                    <img id="profile-preview" src="{{ asset('metronic/media/avatars/300-3.png') }}"
                                         alt="صورة المستخدم" class="w-full h-full object-cover">
                                </div>
                                <label for="photo" class="absolute bottom-0 right-0 bg-primary text-white rounded-full p-2 cursor-pointer hover:bg-primary-dark">
                                    <i class="ki-filled ki-camera text-sm"></i>
                                </label>
                                <input type="file" id="photo" name="photo" class="hidden" accept="image/*">
                            </div>
                            <div class="text-sm text-secondary-foreground">اضغط لتحميل صورة شخصية</div>
                            @error('photo')
                                <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="grid lg:grid-cols-2 gap-6">
                            <!-- First Name -->
                            <div>
                                <label for="first_name" class="kt-label required">الاسم الأول</label>
                                <input type="text" name="first_name" id="first_name" class="kt-input"
                                       placeholder="أدخل الاسم الأول" required value="{{ old('first_name') }}">
                                @error('first_name')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Last Name -->
                            <div>
                                <label for="last_name" class="kt-label required">اسم العائلة</label>
                                <input type="text" name="last_name" id="last_name" class="kt-input"
                                       placeholder="أدخل اسم العائلة" required value="{{ old('last_name') }}">
                                @error('last_name')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="grid lg:grid-cols-2 gap-6">
                            <!-- Email -->
                            <div>
                                <label for="email" class="kt-label required">البريد الإلكتروني</label>
                                <input type="email" name="email" id="email" class="kt-input"
                                       placeholder="example@domain.com" required value="{{ old('email') }}">
                                @error('email')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Username -->
                            <div>
                                <label for="username" class="kt-label">اسم المستخدم</label>
                                <input type="text" name="username" id="username" class="kt-input"
                                       placeholder="username123" value="{{ old('username') }}">
                                @error('username')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="grid lg:grid-cols-2 gap-6">
                            <!-- Phone -->
                            <div>
                                <label for="phone" class="kt-label">رقم الهاتف</label>
                                <input type="tel" name="phone" id="phone" class="kt-input"
                                       placeholder="+966 50 123 4567" value="{{ old('phone') }}">
                                @error('phone')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Date of Birth -->
                            <div>
                                <label for="birth_date" class="kt-label">تاريخ الميلاد</label>
                                <input type="date" name="birth_date" id="birth_date" class="kt-input"
                                       value="{{ old('birth_date') }}">
                                @error('birth_date')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="grid lg:grid-cols-2 gap-6">
                            <!-- Gender -->
                            <div>
                                <label for="gender" class="kt-label">الجنس</label>
                                <select name="gender" id="gender" class="kt-select">
                                    <option value="">اختر الجنس</option>
                                    <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>ذكر</option>
                                    <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>أنثى</option>
                                </select>
                                @error('gender')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Country -->
                            <div>
                                <label for="country_id" class="kt-label">البلد</label>
                                <select name="country_id" id="country_id" class="kt-select">
                                    <option value="">اختر البلد</option>
                                    @foreach($countries as $country)
                                        <option value="{{ $country->id }}" {{ old('country_id') == $country->id ? 'selected' : '' }}>
                                            {{ $country->name_ar }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('country_id')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="grid lg:grid-cols-2 gap-6">
                            <!-- Password -->
                            <div>
                                <label for="password" class="kt-label required">كلمة المرور</label>
                                <input type="password" name="password" id="password" class="kt-input"
                                       placeholder="أدخل كلمة مرور قوية" required>
                                <div class="text-xs text-secondary-foreground mt-1">
                                    يجب أن تحتوي على 8 أحرف على الأقل
                                </div>
                                @error('password')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Confirm Password -->
                            <div>
                                <label for="password_confirmation" class="kt-label required">تأكيد كلمة المرور</label>
                                <input type="password" name="password_confirmation" id="password_confirmation" class="kt-input"
                                       placeholder="أعد إدخال كلمة المرور" required>
                                @error('password_confirmation')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Role -->
                        <div>
                            <label for="role" class="kt-label required">الدور</label>
                            <select name="role" id="role" class="kt-select" required>
                                <option value="">اختر دور المستخدم</option>
                                <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>مدير</option>
                                <option value="moderator" {{ old('role') == 'moderator' ? 'selected' : '' }}>مشرف</option>
                                <option value="user" {{ old('role') == 'user' ? 'selected' : '' }}>مستخدم عادي</option>
                            </select>
                            @error('role')
                                <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Bio -->
                        <div>
                            <label for="bio" class="kt-label">نبذة شخصية</label>
                            <textarea name="bio" id="bio" rows="4" class="kt-input"
                                      placeholder="معلومات إضافية عن المستخدم...">{{ old('bio') }}</textarea>
                            @error('bio')
                                <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- User Settings -->
                        <div class="space-y-4">
                            <h4 class="font-semibold">إعدادات الحساب</h4>

                            <div class="grid lg:grid-cols-2 gap-4">
                                <div class="flex items-center gap-3">
                                    <input type="checkbox" name="is_active" id="is_active" class="kt-checkbox" value="1"
                                           {{ old('is_active', '1') ? 'checked' : '' }}>
                                    <label for="is_active" class="kt-label mb-0">تفعيل الحساب</label>
                                </div>

                                <div class="flex items-center gap-3">
                                    <input type="checkbox" name="email_verified" id="email_verified" class="kt-checkbox" value="1"
                                           {{ old('email_verified') ? 'checked' : '' }}>
                                    <label for="email_verified" class="kt-label mb-0">تأكيد البريد الإلكتروني</label>
                                </div>

                                <div class="flex items-center gap-3">
                                    <input type="checkbox" name="notifications_enabled" id="notifications_enabled" class="kt-checkbox" value="1"
                                           {{ old('notifications_enabled', '1') ? 'checked' : '' }}>
                                    <label for="notifications_enabled" class="kt-label mb-0">تفعيل الإشعارات</label>
                                </div>

                                <div class="flex items-center gap-3">
                                    <input type="checkbox" name="marketing_emails" id="marketing_emails" class="kt-checkbox" value="1"
                                           {{ old('marketing_emails') ? 'checked' : '' }}>
                                    <label for="marketing_emails" class="kt-label mb-0">الرسائل التسويقية</label>
                                </div>
                            </div>
                        </div>

                        <!-- Submit Buttons -->
                        <div class="flex items-center gap-4 pt-4">
                            <button type="submit" class="kt-btn kt-btn-primary">
                                <i class="ki-filled ki-check text-sm me-2"></i>
                                إنشاء المستخدم
                            </button>
                            <button type="submit" name="save_and_add" value="1" class="kt-btn kt-btn-outline kt-btn-outline-primary">
                                <i class="ki-filled ki-plus text-sm me-2"></i>
                                حفظ وإضافة آخر
                            </button>
                            <a href="{{ route('users.index') }}" class="kt-btn kt-btn-outline">
                                إلغاء
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Security Tips -->
            <div class="kt-card">
                <div class="kt-card-header">
                    <h3 class="kt-card-title">نصائح أمنية</h3>
                </div>
                <div class="kt-card-body">
                    <div class="space-y-3">
                        <div class="flex items-center gap-3">
                            <div class="bg-success-light rounded-full p-2">
                                <i class="ki-filled ki-shield-tick text-success"></i>
                            </div>
                            <div>
                                <div class="font-semibold">كلمة مرور قوية</div>
                                <div class="text-sm text-secondary-foreground">استخدم مزيج من الأحرف والأرقام والرموز</div>
                            </div>
                        </div>

                        <div class="flex items-center gap-3">
                            <div class="bg-warning-light rounded-full p-2">
                                <i class="ki-filled ki-information text-warning"></i>
                            </div>
                            <div>
                                <div class="font-semibold">تحديد الصلاحيات</div>
                                <div class="text-sm text-secondary-foreground">امنح المستخدم الصلاحيات المناسبة لدوره فقط</div>
                            </div>
                        </div>

                        <div class="flex items-center gap-3">
                            <div class="bg-primary-light rounded-full p-2">
                                <i class="ki-filled ki-message-text-2 text-primary"></i>
                            </div>
                            <div>
                                <div class="font-semibold">تأكيد البريد الإلكتروني</div>
                                <div class="text-sm text-secondary-foreground">تأكد من صحة البريد الإلكتروني قبل التفعيل</div>
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
    // Photo preview
    document.getElementById('photo').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('profile-preview').src = e.target.result;
            };
            reader.readAsDataURL(file);
        }
    });

    // Auto-generate username from first and last name
    function generateUsername() {
        const firstName = document.getElementById('first_name').value;
        const lastName = document.getElementById('last_name').value;
        const usernameField = document.getElementById('username');

        if (firstName && lastName && !usernameField.value) {
            const username = (firstName + lastName).toLowerCase().replace(/\s+/g, '');
            usernameField.value = username;
        }
    }

    document.getElementById('first_name').addEventListener('blur', generateUsername);
    document.getElementById('last_name').addEventListener('blur', generateUsername);

    // Password strength indicator
    document.getElementById('password').addEventListener('input', function() {
        const password = this.value;
        // Add password strength validation here
    });
</script>
@endpush
