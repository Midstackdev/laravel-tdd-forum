<?php

namespace App\Models\Traits;

use App\Models\Favourite;


trait Favouriteable 
{
    protected static function bootFavouriteable()
    {
        static::deleting(function ($model) {
            $model->favourites->each->delete();
        });
    }

    public function favourites()
    {
        return $this->morphMany(Favourite::class, 'favourited');
    }

    public function favourite()
    {
        $attributes = ['user_id' => auth()->id()];
        if (!$this->favourites()->where($attributes)->exists()) {

            return $this->favourites()->create($attributes);
        }
    }

    public function unfavourite()
    {
        $attributes = ['user_id' => auth()->id()];

        $this->favourites()->where($attributes)->get()->each->delete();
    }

     public function isFavourited()
     {
        // $attributes = ['user_id' => auth()->id()];
        return !! $this->favourites->where('user_id',  auth()->id())->count();
     }

     public function getIsFavouritedAttribute()
     {
        // $attributes = ['user_id' => auth()->id()];
        return $this->isFavourited();
     }

     public function getFavouritesCountAttribute()
     {
        return $this->favourites->count();
     }
}