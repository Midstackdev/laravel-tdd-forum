<reply :attributes="{{ $reply }}" inline-template v-cloak>
	<div id="reply-{{ $reply->id }}" class="card mb-2">
		<div class="card-header">
			<div class="level">
				<h5 class="flex">
					<a href="#">{{ $reply->owner->name }}</a> said
					{{ $reply->created_at->diffForHumans() }}
				</h5>

				@if(auth()->check())
					<div>
						<favourite :reply="{{ $reply }}"></favourite>
					</div>
				@endif
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
				<button class="btn btn-danger btn-sm mr-1" type="button" @click="destroy">Delete</button>
			</div>
		@endcan
	</div>
</reply>