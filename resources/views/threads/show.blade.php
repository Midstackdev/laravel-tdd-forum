
@extends('layouts.app')

@section('content')
<thread-view inline-template :initial-replies-count="{{ $thread->repliesCount }}">
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <div class="card mb-4">
                    <div class="card-header">
                        <div class="level">
                            <span class="flex">
                            	<a href="{{ route('profiles.show', $thread->creator->name) }}">{{ $thread->creator->name }}</a> posted:
                            	{{ $thread->title }}
                            </span>

                            @can('update', $thread)
                                <form action="{{ $thread->path() }}" method="POST">
                                    @csrf
                                    @method('delete')
                                    <button class="btn btn-danger" type="submit">Delete Thread</button>
                                </form>
                            @endcan
                        </div>
                    </div>

                    <div class="card-body">
                    	<div class="thread-body"> {{ $thread->body }} </div>

                    </div>
                </div>

                <replies @removed="repliesCount--" @added="repliesCount++"></replies>

                
            </div>
            <div class="col-md-4">
                <div class="card mb-4">
                    <div class="card-header">
                        <a href="{{ route('profiles.show', $thread->creator->name) }}">{{ $thread->creator->name }}</a> posted:
                        {{ $thread->title }}
                    </div>

                    <div class="card-body">
                        <p>
                          This thread was pusblished by {{ $thread->created_at->diffForHumans() }} by
                          <a href="{{ route('profiles.show', $thread->creator->name) }}">{{ $thread->creator->name }}</a>, and currently has 
                          <span v-text="repliesCount"></span> {{ Str::plural('comment', $thread->replies_count)}}.  
                        </p>

                        <p>
                            <subscribe-button :is-susbcribed-to="{{ json_encode($thread->isSubscribedTo) }}"></subscribe-button>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</thread-view>
@endsection
