<div class="card mb-4">
    <div class="card-header">
        <div class="level">
            <span class="flex">
                {{ $heading }}
            </span>
            <span>
                {{-- {{ $thread->created_at->diffForHumans() }} --}}
            </span>
        </div>
    </div>

    <div class="card-body">
        <div class="thread-body"> 
            {{ $body }} 
        </div>

    </div>
</div>