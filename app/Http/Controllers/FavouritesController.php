<?php

namespace App\Http\Controllers;

use App\Models\Favourite;
use App\Models\Reply;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FavouritesController extends Controller
{

	public function __construct()
	{
		$this->middleware('auth');
	}

    public function store(Reply $reply)
    {
    	return $reply->favourite();
    }
}
