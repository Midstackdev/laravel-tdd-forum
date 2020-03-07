 @extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Create a new thread</div>

                <div class="card-body">
                	<form method="post" action="/threads">
                		@csrf
                		<div class="form-group">
                			<label>Channel</label>
                			<select class="form-control" name="channel_id" id="channel_id" required>
                                <option value="">Choose one</option>
                                @foreach($channels as $channel)
                                    <option value="{{ $channel->id }}" {{ old('channel_id') == $channel->id ? 'selected' : ''}}>{{ $channel->name }}</option>
                                @endforeach
                            </select>
                            @error('title')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                		</div>
                        <div class="form-group">
                            <label>Title</label>
                            <input type="text" class="form-control" name="title" id="title" value="{{ old('title') }}" required>
                            @error('title')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                		<div class="form-group">
                			<label>Body</label>
                			<textarea class="form-control" name="body" id="body" rows="8" required>{{ old('body') }}</textarea>
                            @error('body')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                		</div>

                		<button type="submit" class="btn btn-primary">Publish</button>

                	</form>
                </div>
            </div> 
        </div>
    </div>
</div>
@endsection
