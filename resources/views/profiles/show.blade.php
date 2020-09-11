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
                @forelse($activities as $date => $activity)
                    <h3 class="page-header"><small>{{ $date }}</small></h3>
                    @foreach($activity as $record)
                        @if(view()->exists("profiles.partials.activities._$record->type"))
                            @include("profiles.partials.activities._$record->type", ['activity' => $record])
                        @endif
                    @endforeach
                @empty
                    <p class="lead">There is no activity for this user yet.</p>     
                @endforelse
            </div>
        </div>

        {{-- {{ $threads->links() }} --}}
    </div>

@endsection