<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    use Notifiable;

    public $timestamps  = false;
    protected $table = 'rating';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'auctionid', 'winnerid', 'value', 'datehour', 'comment'
    ];

    public function seller()
    {
        return $this->belongsTo('App\Models\User', 'winnerid')->withPivot('value', 'datehour', 'comment');
    }

    public function rated()
    {
        return $this->belongsToMany('App\Models\Auction', 'auctionid')->withPivot('value', 'datehour', 'comment');
    }
}
