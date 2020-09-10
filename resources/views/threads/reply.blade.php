<div id="reply-{{ $reply->id }}" class="card mb-2">
	<div class="card-header">
		<div class="level">
			<h5 class="flex">
				<a href="#">{{ $reply->owner->name }}</a> said
				{{ $reply->created_at->diffForHumans() }}
			</h5>

			<div>
				<form method="post" action="/replies/{{ $reply->id }}/favourites">
					@csrf
					<button type="submit" class="btn btn-primary" {{ $reply->isFavourited() ? 'disabled' : '' }}>
						{{ $reply->favourites_count }} {{Str::plural('Favourite', $reply->favourites_count )}}
					</button>
				</form>
			</div>
		</div>	
		
	</div>
	<div class="card-body">
		<div class="body"> {{ $reply->body }} </div>
	</div>
</div>