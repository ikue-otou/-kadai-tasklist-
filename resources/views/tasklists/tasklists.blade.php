<ul class="media-list">
    @foreach ($tasklists as $tasklist)
        <li class="media mb-3">
            <img class="mr-2 rounded" src="{{ Gravatar::src($tasklist->user->email, 50) }}" alt="">
            <div class="media-body">
                
                <div>
                    {!! link_to_route('users.show', $tasklist->user->name, ['id' => $tasklist->user->id]) !!} <span class="text-muted">posted at {{ $tasklist->created_at }}</span>
                </div>
                <div>
                    <p class="mb-0">{!! nl2br(e($tasklist->content)) !!}</p>
                </div>
                 <div>
                    @if (Auth::id() == $tasklist->user_id)
                        {!! Form::open(['route' => ['tasklists.destroy', $tasklist->id], 'method' => 'delete']) !!}
                            {!! Form::submit('Delete', ['class' => 'btn btn-danger btn-sm']) !!}
                        {!! Form::close() !!}
                    @endif
                </div>
            </div>
        </li>
    @endforeach
</ul>
{{ $tasklists->links('pagination::bootstrap-4') }}