@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 offset-2">
                
                <div class="page-header">
                    <h1>
                        {{ $profileUser->name }}
                        <small>Since {{ $profileUser->created_at->diffForHumans() }}</small>
                    </h1>
                </div>
                @foreach($threads as $thread)

                    <div class="card mb-4">
                        <div class="card-header">
                            <div class="level">
                                <span class="flex">
                                    <a href="{{ route('profiles.show', $thread->creator->name) }}">{{ $thread->creator->name }}</a> posted:
                                    {{ $thread->title }}
                                </span>
                                <span>{{ $thread->created_at->diffForHumans() }}</span>
                            </div>
                        </div>

                        <div class="card-body">
                            <div class="thread-body"> {{ $thread->body }} </div>

                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        {{ $threads->links() }}
    </div>

@endsection