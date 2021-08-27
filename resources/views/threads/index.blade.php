@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            @include('threads.partials._list')

            {{ $threads->links() }}
        </div>

        <div class="col-md-4">
        	@if(count($trending))
        	<div class="card mb-2">
        	    <div class="card-header">
        	        Trending Threads
        	    </div>

        	    {{-- <div class=""> --}}
        	    	@foreach($trending as $thread)
        	    	    <ul class="list-group list-group-flush">
        	    	       <li class="list-group-item">
        	    	       	 	<a href="{{ url($thread->path) }}">
        	    	       	 	   {{ $thread->title }}
        	    	       	    </a>
        	    	       </li>
        	    	     </ul>
        	        @endforeach
        	    {{-- </div> --}}
        	</div> 
        	@endif
        </div>
    </div>
</div>
@endsection
