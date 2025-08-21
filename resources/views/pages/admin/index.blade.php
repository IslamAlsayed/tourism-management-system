@extends('admin.base')

@push('styles')
    <style>
        @keyframes down-btn {
            0% {
                bottom: 20px;
            }

            100% {
                bottom: 0px;
            }

            0% {
                opacity: 0;
            }

            100% {
                opacity: 1;
            }
        }

        @-webkit-keyframes down-btn {
            0% {
                bottom: 20px;
            }

            100% {
                bottom: 0px;
            }

            0% {
                opacity: 0;
            }

            100% {
                opacity: 1;
            }
        }

        @-moz-keyframes down-btn {
            0% {
                bottom: 20px;
            }

            100% {
                bottom: 0px;
            }

            0% {
                opacity: 0;
            }

            100% {
                opacity: 1;
            }
        }

        @-o-keyframes down-btn {
            0% {
                bottom: 20px;
            }

            100% {
                bottom: 0px;
            }

            0% {
                opacity: 0;
            }

            100% {
                opacity: 1;
            }
        }

        .category-name {
            font-size: 40px;
        }

        .card-category-1 {
            gap: 10px;
            display: flex;
            flex-wrap: wrap;
            margin-bottom: 45px;
            justify-content: center;
        }

        .card-category-1>div {
            display: inline-block;
        }

        .card-category-1>div {
            text-align: left;
        }

        /* Basic Card */
        .basic-card {
            width: 300px;
            position: relative;

            -webkit-box-shadow: 0px 5px 5px 0px rgba(0, 0, 0, 0.3);
            -moz-box-shadow: 0px 5px 5px 0px rgba(0, 0, 0, 0.3);
            -o-box-shadow: 0px 5px 5px 0px rgba(0, 0, 0, 0.3);
            box-shadow: 0px 5px 5px 0px rgba(0, 0, 0, 0.3);
        }

        .basic-card .card-content {
            padding: 10px;
        }

        .basic-card .card-title {
            font-size: 16px;
            font-family: 'Open Sans', sans-serif;
        }

        .basic-card .card-text {
            line-height: 1.6;
        }

        .basic-card .card-link {
            padding: 5px;
            width: -webkit-fill-available;
        }

        .basic-card .card-link a {
            text-decoration: none;
            position: relative;
            padding: 10px 0px;
        }

        .basic-card .card-link a:after {
            top: 30px;
            content: "";
            display: block;
            height: 2px;
            left: 50%;
            position: absolute;
            width: 0;

            -webkit-transition: width 0.3s ease 0s, left 0.3s ease 0s;
            -moz-transition: width 0.3s ease 0s, left 0.3s ease 0s;
            -o-transition: width 0.3s ease 0s, left 0.3s ease 0s;
            transition: width 0.3s ease 0s, left 0.3s ease 0s;
        }

        .basic-card .card-link a:hover:after {
            width: 100%;
            left: 0;
        }


        .basic-card-aqua {
            background-image: linear-gradient(to bottom right, #00bfad, #99a3d4);
        }

        .basic-card-aqua .card-content,
        .basic-card .card-link a {
            color: #fff;
        }

        .basic-card-aqua .card-link {
            border-top: 1px solid #82c1bb;
        }

        .basic-card-aqua .card-link a:after {
            background: #fff;
        }

        .basic-card-lips {
            background-image: linear-gradient(to bottom right, #ec407b, #ff7d94);
        }

        .basic-card-lips .card-content {
            color: #fff;
        }

        .basic-card-lips .card-link {
            border-top: 1px solid #ff97ba;
        }

        .basic-card-lips .card-link a:after {
            background: #fff;
        }

        .basic-card-light {
            border: 1px solid #eee;
        }

        .basic-card-light .card-title,
        .basic-card-light .card-link a {
            color: #636363;
        }

        .basic-card-light .card-text {
            color: #7b7b7b;
        }

        .basic-card-light .card-link {
            border-top: 1px solid #eee;
        }

        .basic-card-light .card-link a:after {
            background: #636363;
        }

        .basic-card-dark {
            background-image: linear-gradient(to bottom right, #252525, #4a4a4a);
        }

        .basic-card-dark .card-title,
        .basic-card-dark .card-link a {
            color: #eee;
        }

        .basic-card-dark .card-text {
            color: #dcdcdcdd;
        }

        .basic-card-dark .card-link {
            border-top: 1px solid #636363;
        }

        .basic-card-dark .card-link a:after {
            background: #eee;
        }
    </style>
@endpush

@section('content')
    <!-- Container -->
    <div class="kt-container-fixed" id="contentContainer">
    </div>
    <!-- End of Container -->
    <!-- Container -->
    <div class="kt-container-fixed">
        <div class="flex flex-wrap items-center justify-between gap-5 pb-7.5 lg:items-end">
            <div class="flex flex-col justify-center gap-2">
                <h1 class="text-xl font-medium leading-none text-mono">
                    Dashboard
                </h1>
                <div class="flex items-center gap-2 text-sm font-normal text-secondary-foreground">
                    Central Hub for Personal Customization
                </div>
            </div>
            <div class="flex items-center gap-2.5">
                <a class="kt-btn kt-btn-outline" href="#">
                    View Profile
                </a>
            </div>
        </div>
    </div>
    <!-- End of Container -->

    <div class="card-category-1">

        <div class="basic-card basic-card-aqua">
            <div class="card-content w-100 flex flex-wrap items-center justify-between">
                <span class="card-title">Users</span>
                <span class="card-text" style="font-size: 20px">{{ $stats['users'] }}</span>
            </div>

            <div class="card-link">
                <a href="#" title="View"><span>View</span></a>
            </div>
        </div>

        <div class="basic-card basic-card-lips">
            <div class="card-content w-100 flex flex-wrap items-center justify-between">
                <span class="card-title">Countries</span>
                <span class="card-text" style="font-size: 20px">{{ $stats['countries'] }}</span>
            </div>

            <div class="card-link">
                <a href="#" title="View"><span>View</span></a>
            </div>
        </div>

        <div class="basic-card basic-card-light">
            <div class="card-content w-100 flex flex-wrap items-center justify-between">
                <span class="card-title">Cities</span>
                <span class="card-text" style="font-size: 20px">{{ $stats['cities'] }}</span>
            </div>

            <div class="card-link">
                <a href="#" title="View"><span>View</span></a>
            </div>
        </div>

        <div class="basic-card basic-card-dark">
            <div class="card-content w-100 flex flex-wrap items-center justify-between">
                <span class="card-title">Currencies</span>
                <span class="card-text" style="font-size: 20px">{{ $stats['currencies'] }}</span>
            </div>

            <div class="card-link">
                <a href="#" title="View"><span>View</span></a>
            </div>
        </div>
    </div>
@endsection
