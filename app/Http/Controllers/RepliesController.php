<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatePostFormRequest;
use App\Models\Reply;
use App\Models\Thread;
use App\Rules\SpamFree;
use Illuminate\Http\Request;

class RepliesController extends Controller
{
	public function __construct()
	{
		$this->middleware('auth', ['except' => 'index']);
	}

    public function index($channelId, Thread $thread)
    {
        return $thread->replies()->paginate(25);
    }

    public function store($channelId, Thread $thread,  CreatePostFormRequest $form)
    {
    	return $thread->addReply([
    		'body' => request('body'),
    		'user_id' => auth()->id()
    	])->load('owner');
        	
    }

    public function update(Reply $reply)
    {
        try {
            
            $this->authorize('update', $reply);

            $this->validate(request(), [
                'body' => ['required', new SpamFree]
            ]);

            $reply->update(request(['body']));
        } catch (\Exception $e) {
            return response('Sorry, your reply could not be saved at this time.', 422);
        }
    }

    public function destroy(Reply $reply)
    {
        $this->authorize('update', $reply);

        $reply->delete();

        if(request()->wantsJson()) {
            return response(['status' => 'Reply deleted']);
        }

        return back();
    }

    protected function validateReply()
    {
        $this->validate(request(), [
            'body' => 'required|spamfree'
        ]);

        // resolve(Spam::class)->detect(request('body'));
    }
}
