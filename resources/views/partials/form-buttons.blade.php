
<div class="form-group">
    <div class="col-sm-10">
        <div class="text-right">
            <button class="btn btn-primary">{{ $saveText or 'Save' }}</button>
            @if(isset($cancelLink))
                <a href="{{ $cancelLink }}" class="btn btn-default">{{ $cancelText or 'Cancel' }}</a>
            @endif
        </div>
    </div>
</div>
