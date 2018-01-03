@section('content-header')
    <div class="page-header header-toolbar-container">
        @if(isset($title) && $title)
            <div class="pull-left">
                <h1 class="content-header">{{ $title }}</h1>
            </div>
        @endif
@endsection
