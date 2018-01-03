<!DOCTYPE html>
<html>
<head>
    @include('partials.page-meta')
    @include('partials.page-css')
    <title>@yield('title')</title>
</head>
<body>
<div id="login-wrapper">

    @include('partials.header')

    <div id="app">
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
            <div class="col-lg-12">
                @include('partials.flash')
            </div>
            @yield('content')
        </div>
    </div>

    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
                <div class="col-lg-12">
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
