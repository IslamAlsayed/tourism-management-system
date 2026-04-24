@extends('layouts.metronic')

@section('content')
<!--begin::Card-->
<div class="kt-card">
    <div class="kt-card-header border-0 pt-6">
        <div class="kt-card-title">
            <h2 class="fw-bold">الدول</h2>
        </div>
        <div class="kt-card-toolbar">
            <div class="d-flex justify-content-end" data-kt-user-table-toolbar="base">
                <button type="button" class="kt-btn kt-btn-light kt-btn-primary me-3" id="kt_export_button">
                    <i class="fa-duotone fa-solid fa-arrow-up-from-bracket fs-2"></i>تصدير
                </button>
                <button type="button" class="kt-btn kt-btn-light kt-btn-success me-3" id="kt_bulk_edit_button">
                    <i class="fa-duotone fa-solid fa-pen fs-2"></i>تعديل جماعي
                </button>
                <button type="button" class="kt-btn kt-btn-light kt-btn-secondary" id="kt_toggle_columns">
                    <i class="fa-duotone fa-solid fa-table-columns fs-2"></i>إظهار/إخفاء الأعمدة
                </button>
            </div>
        </div>
    </div>
    <div class="kt-card-body py-4">
        <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_countries_table">
            <thead>
                <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
                    <th><input class="form-check-input" type="checkbox" id="kt_select_all"></th>
                    <th>العلم</th>
                    <th>الدولة</th>
                    <th>العملة</th>
                    <th>العاصمة</th>
                    <th>كود الهاتف</th>
                    <th>القارة</th>
                    <th>عدد السكان</th>
                    <th>المساحة</th>
                    <th>نشط؟</th>
                    <th>إجراءات</th>
                </tr>
            </thead>
            <tbody>
                <!-- بيانات تجريبية -->
                <tr>
                    <td><input class="form-check-input" type="checkbox"></td>
                    <td><img src="https://flagcdn.com/w40/sa.png" alt="SA" class="w-30px h-20px"></td>
                    <td>السعودية</td>
                    <td>ريال سعودي</td>
                    <td>الرياض</td>
                    <td>+966</td>
                    <td>آسيا</td>
                    <td>35,000,000</td>
                    <td>2,149,690 كم²</td>
                    <td><span class="kt-badge kt-badge-light kt-badge-success">نشط</span></td>
                    <td>
                        <button class="kt-btn kt-btn-sm kt-btn-light kt-btn-ghost" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">إجراءات
                            <span class="svg-icon svg-icon-5 m-0">
                                <i class="fa-duotone fa-solid fa-chevron-down fs-5"></i>
                            </span>
                        </button>
                        <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-semibold py-4 w-150px" data-kt-menu="true">
                            <div class="menu-item px-3">
                                <a href="#" class="menu-link px-3">تعديل</a>
                            </div>
                            <div class="menu-item px-3">
                                <a href="#" class="menu-link px-3">حذف</a>
                            </div>
                            <div class="menu-item px-3">
                                <a href="#" class="menu-link px-3">تفعيل/تعطيل</a>
                            </div>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td><input class="form-check-input" type="checkbox"></td>
                    <td><img src="https://flagcdn.com/w40/eg.png" alt="EG" class="w-30px h-20px"></td>
                    <td>مصر</td>
                    <td>جنيه مصري</td>
                    <td>القاهرة</td>
                    <td>+20</td>
                    <td>أفريقيا</td>
                    <td>104,000,000</td>
                    <td>1,010,408 كم²</td>
                    <td><span class="kt-badge kt-badge-light kt-badge-destructive">غير نشط</span></td>
                    <td>
                        <button class="kt-btn kt-btn-sm kt-btn-light kt-btn-ghost" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">إجراءات
                            <span class="svg-icon svg-icon-5 m-0">
                                <i class="fa-duotone fa-solid fa-chevron-down fs-5"></i>
                            </span>
                        </button>
                        <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-semibold py-4 w-150px" data-kt-menu="true">
                            <div class="menu-item px-3">
                                <a href="#" class="menu-link px-3">تعديل</a>
                            </div>
                            <div class="menu-item px-3">
                                <a href="#" class="menu-link px-3">حذف</a>
                            </div>
                            <div class="menu-item px-3">
                                <a href="#" class="menu-link px-3">تفعيل/تعطيل</a>
                            </div>
                        </div>
                    </td>
                </tr>
                <!-- نهاية البيانات التجريبية -->
            </tbody>
        </table>
    </div>
</div>
<!--end::Card-->

<!--begin::JS-->
@push('scripts')
<script src="/metronic/plugins/custom/datatables/datatables.bundle.js"></script>
<script>
    $(document).ready(function() {
        $('#kt_countries_table').DataTable({
            language: {
                url: '//cdn.datatables.net/plug-ins/1.13.4/i18n/ar.json'
            },
            dom: 'Bfrtip',
            buttons: [
                'copy', 'csv', 'excel', 'pdf', 'print',
                {
                    extend: 'colvis',
                    text: 'إظهار/إخفاء الأعمدة'
                }
            ],
            select: true
        });
    });
</script>
@endpush
<!--end::JS-->
@endsection
