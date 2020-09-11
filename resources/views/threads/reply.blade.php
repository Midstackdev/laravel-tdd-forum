<reply :attributes="{{ $reply }}" inline-template v-cloak>
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
			<div v-if="editing">
				<div class="form-group">
					<textarea name="" v-model="body" class="form-control"></textarea>
				</div>
				<button class="btn btn-sm btn-outline-danger" @click="editing = false">Cancel</button>
				<button class="btn btn-sm btn-outline-success" @click="update">Update</button>
			</div>
			<div v-else v-text="body"></div>
		</div>

		@can('update', $reply)
			<div class="card-footer text-muted level">
				<button class="btn btn-light btn-sm mr-1" type="button" @click="editing = true">Edit</button>
			    <form action="/replies/{{ $reply->id }}" method="POST">
			        @csrf
			        @method('delete')
			        <button class="btn btn-danger btn-sm" type="submit">Delete</button>
			    </form>
			</div>
		@endcan
	</div>
</reply>