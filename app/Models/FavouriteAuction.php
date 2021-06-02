<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

class FavouriteAuction extends Model
{
    use Notifiable;

    // Don't add create and update timestamps in database.
    public $timestamps  = false;
    protected $table = 'favouriteauction';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id','userid', 'auctionid'
    ];

    public function owner()
    {
        return $this->belongsToMany('App\Models\User', 'userid');
    }

    public function auction()
    {
        return $this->belongsTo('App\Models\Auction', 'auctionid');
    }
}
