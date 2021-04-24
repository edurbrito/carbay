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
        'name', 'username', 'email', 'password', 'image', 'banned', 'admin',
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
        return $this->hasMany('App\Models\Auction', 'sellerID');
    }

    public function bids()
    {
        return $this->hasMany('App\Models\Bid', 'authorID');
    }

    public function favouriteAuctions()
    {
        return $this->belongsToMany('App\Models\FavouriteAuction', 'userID');
    }
}
