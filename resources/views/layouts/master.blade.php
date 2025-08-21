<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-kt-name="metronic" data-kt-version="8.2.1" data-kt-color-theme="light" data-kt-layout="dark-sidebar" data-kt-layout-config="{&quot;app&quot;:{&quot;header&quot;:{&quot;fixed&quot;:{&quot;desktop&quot;:true,&quot;tabletAndMobile&quot;:false}},&quot;sidebar&quot;:{&quot;fixed&quot;:true,&quot;minimized&quot;:false,&quot;minimize&quot;:{&quot;toggle&quot;:true,&quot;default&quot;:false,&quot;hoverable&quot;:true},&quot;push&quot;:{&quot;header&quot;:true,&quot;toolbar&quot;:true,&quot;footer&quot;:true}},&quot;content&quot;:{&quot;container&quot;:&quot;fixed&quot;},&quot;toolbar&quot;:{&quot;fixed&quot;:{&quot;desktop&quot;:true,&quot;tabletAndMobile&quot;:false}},&quot;footer&quot;:{&quot;fixed&quot;:{&quot;desktop&quot;:false,&quot;tabletAndMobile&quot;:false}}}}">

<head>
    @include('layouts.partials.head')
</head>

<body id="kt_app_body" data-kt-app-layout="dark-sidebar" data-kt-app-header-fixed="true" data-kt-app-sidebar-enabled="true" data-kt-app-sidebar-fixed="true" data-kt-app-sidebar-hoverable="true" data-kt-app-sidebar-push-header="true" data-kt-app-sidebar-push-toolbar="true" data-kt-app-sidebar-push-footer="true" data-kt-app-toolbar-enabled="true" class="app-default">

    <div class="d-flex flex-column flex-root app-root" id="kt_app_root">
        <div class="app-page flex-column flex-column-fluid" id="kt_app_page">
            
            @include('layouts.partials.header')
            
            <div class="app-wrapper flex-column flex-row-fluid" id="kt_app_wrapper">
                @include('layouts.partials.sidebar')
                
                <div class="app-main flex-column flex-row-fluid" id="kt_app_main">
                    @include('layouts.partials.toolbar')
                    
                    <div id="kt_app_content" class="app-content flex-column-fluid">
                        <div id="kt_app_content_container" class="app-container container-xxl">
                            @yield('content')
                        </div>
                    </div>
                    
                    @include('layouts.partials.footer')
                </div>
            </div>
        </div>
    </div>

    @include('layouts.partials.scripts')
</body>
</html>
