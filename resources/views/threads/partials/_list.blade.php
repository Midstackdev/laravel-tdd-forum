@forelse ($threads as $thread)
    <div class="card mb-2">
        <div class="card-header">
            <div class="level"> 
                <div class="flex">
                    
                    <h4 class=""> 
                         <a href="{{$thread->path()}}">
                            @if(auth()->check() && $thread->hasUpdatesFor(auth()->user()))
                                <strong>
                                    {{ $thread->title }}
                                </strong>
                            @else
                                {{ $thread->title }}
                            @endif
                         </a>
                     </h4>
                     <h5>Posted By: 
                        <a href="{{ route('profiles.show', $thread->creator) }}">{{ $thread->creator->name }}</a>
                    </h5>
                </div>
                <a href="{{ $thread->path() }}">{{ $thread->replies_count }} {{ Str::plural('reply', $thread->replies_count )}}</a>
             </div>
        </div>

        <div class="card-body">
                <article>
                   <div class="body"> {{ $thread->body }} </div>
                </article>
        </div>
    </div> 
@empty
    <p class="lead">There are no relevant results at this time.</p>
@endforelse