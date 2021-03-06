@component('profiles.partials.activities._activity')

    @slot('heading')
        {{ $profileUser->name }} replied to a 
        <a href="{{ $activity->subject->thread->path() }}">{{ $activity->subject->thread->title }}</a>
    @endslot

    @slot('body')
       {{ $activity->subject->body }}  
    @endslot

@endcomponent