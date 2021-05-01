<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    // Don't add create and update timestamps in database.
    public $timestamps  = false;
    protected $table = 'user';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'name', 'username', 'email', 'password', 'image', 'banned', 'admin',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function auctions()
    {
        return $this->hasMany('App\Models\Auction', 'sellerid');
    }

    public function bids()
    {
        return $this->hasMany('App\Models\Bid', 'authorid');
    }

    public function favouriteAuctions()
    {
        return $this->hasMany('App\Models\FavouriteAuction', 'userid');
    }
    
    public function comments()
    {
        return $this->hasMany('App\Models\Comment', 'authorid');
    }

    public function ratings()
    {
        $ratings = [];
        foreach ($this->auctions as $auction) { 
            $rating_value = $auction->rating_value();
            if ($rating_value > 0) {
                array_push($ratings, $auction->rating());
            }
        }
        return $ratings;
    }

    public function rated()
    {
        return $this->hasMany('App\Models\Rating', 'winnerid');
    }

    public function rating_value()
    {
        $value = 0;
        $count = 0;
        foreach ($this->auctions as $auction) { 
            $rating = $auction->rating_value();
            if($rating > 0) {
                $value += $rating;
                $count += 1;
            }
        }
        if($count > 0)
            return $value / $count;
        else 
            return 0;
    }

    public function num_ratings()
    {
        $count = 0;
        foreach ($this->auctions as $auction) { 
            $rating = $auction->rating_value();
            if($rating > 0) {
                $count += 1;
            }
        }
        return $count;
    }
}
