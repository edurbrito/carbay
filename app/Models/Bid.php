<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

class Bid extends Model
{
    use Notifiable;

    // Don't add create and update timestamps in database.
    public $timestamps  = false;
    protected $table = 'Bid';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'value', 'dateHour', 'authorID', 'auctionID'
    ];

    public function bidAuction()
    {
        return $this->belongsTo('App\Models\Auction', 'auctionID');
    }

    public function author()
    {
        return $this->belongsTo('App\Models\User', 'authorID');
    }
}
