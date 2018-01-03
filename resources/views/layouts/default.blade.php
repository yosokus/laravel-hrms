<!DOCTYPE html>
<html>
<head>
    @include('partials.page-meta')
    @include('partials.page-css')
    <title>@yield('title')</title>
</head>
<body>
<div id="wrapper">

    @include('partials.header')

    <div class="container-fluid">
        <div class="row">
            <div id="sidebar-wrapper" class="col-sm-3 col-md-2 sidebar">
                @include('partials.sidebar')
            </div>

            <div id="page-wrapper" class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
                <!-- Page Heading -->
                <div class="row">
                    @section('content-header')
                        <div class="page-header">
                            <h1 class="content-header">@yield('title')</h1>
                        </div>
                    @show
                </div>

                <div id="app">
                    <div class="row">
                        @include('partials.flash')
                    </div>
                    <div class="row">
                        @yield('content')
                    </div>
                </div>

                <div class="row">
                    @include('partials.footer')
                </div>
            </div>
        </div>
    </div>
</div>

@include('partials.page-js')
@yield('footerJs')
</body>
</html>
