<?php

namespace App\Models;

use App\Models\Traits\Favouriteable;
use App\Models\Traits\RecordsActivity;
use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{
    use Favouriteable, RecordsActivity;
    
	protected $guarded = [];

    protected $with = ['owner', 'favourites'];

    protected $appends = ['favouritesCount'];
	
    public function owner()
    {
    	return $this->belongsTo(User::class, 'user_id');
    }

    
}
