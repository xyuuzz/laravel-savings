@php 
    $sessions = [session("create"), session("delete"), session("update")]; 
@endphp

@foreach ($sessions as $session )
    @if ($session)
        <div class="container">
            <div class="alert alert-success">
                {{$session}}
            </div>
        </div>
    @endif
@endforeach