
@if(Session::has('flash_message'))
    <div class="ui icon positive message">
        <i class="check circle icon"></i>
        <div class="content">
            <p>{!!  Session::get('flash_message') !!}</p>
        </div>
    </div>
@endif


@if(Session::has('flash_message_error'))
    <div class="ui icon error message">
        <i class="exclamation triangle icon"></i>
        <div class="content">
            <p>{!!  Session::get('flash_message_error') !!}</p>
        </div>
    </div>
@endif
