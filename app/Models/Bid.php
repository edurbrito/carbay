<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

class Bid extends Model
{
    use Notifiable;

    // Don't add create and update timestamps in database.
    public $timestamps  = false;
    protected $table = 'bid';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'value', 'datehour', 'authorid', 'auctionid'
    ];

    public function bidAuction()
    {
        return $this->belongsTo('App\Models\Auction', 'auctionid');
    }

    public function author()
    {
        return $this->belongsTo('App\Models\User', 'authorid');
    }

    public function rdate()
    {
        $matches = null;
        if(preg_match('/.+(?=:)/', $this->datehour, $matches))
            return $matches[0];

        return $this->datehour;
    }
}
