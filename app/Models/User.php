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
        return $this->belongsToMany('App\Models\FavouriteAuction', 'userid');
    }
    
    public function comments()
    {
        return $this->hasMany('App\Models\Comment', 'authorID');
    }

    public function rating()
    {
        $value = 0;
        $count = 0;
        foreach ($this->auctions as $auction) { 
            $rating = $auction->rating();
            if($rating > 0) {
                $value += $auction->rating();
                $count += 1;
            }
        }
        if($count > 0)
            return $value / $count;
        else 
            return 0;
    }
}
