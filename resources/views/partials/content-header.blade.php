@section('content-header')
    <div class="page-header header-toolbar-container">
        @if(isset($title) && $title)
            <div class="pull-left">
                <h1 class="content-header">{{ $title }}</h1>
            </div>
        @endif

        <div class="toolbar-icons pull-right">
            <div class="toolbar-btns clearfix">
                @if(isset($addLink) && $addLink)
                    <a class="btn-toolbar" href="{{ $addLink }}">
                        <i class="fa fa-2x fa-plus-circle"></i>
                        <span>Add</span>
                    </a>
                @endif
                @if(isset($editLink) && $editLink)
                    <a class="btn-toolbar" href="{{ $editLink }}">
                        <i class="fa fa-2x fa-edit"></i>
                        <span>Edit</span>
                    </a>
                @endif
                @if(isset($backLink) && $backLink)
                    <a class="btn-toolbar" href="{{ $backLink }}">
                        <i class="fa fa-2x fa-arrow-circle-left"></i>
                        <span>Back</span>
                    </a>
                @endif
                @if(isset($deleteLink) && $deleteLink)
                    <a class="btn-toolbar" href="{{ $deleteLink }}">
                        <i class="fa fa-2x fa-times-circle"></i>
                        <span>Delete</span>
                    </a>
                @endif
            </div>
        </div>
    </div>
@endsection
