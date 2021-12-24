
@forelse($notifies as $notify)
    <ul class="list-group list-group-flush">
        <li class="notify-user-item list-group-item" data-userid="{{$notify->id}}">
            {{$notify->name}}
        </li>
    </ul>
@empty
    <p class="text-center">고객을 찾을 수 없습니다..</p>
@endforelse