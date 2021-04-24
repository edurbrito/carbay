<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    use Notifiable;

    public $timestamps  = false;
    protected $table = 'Rating';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'auctionID', 'winnerID', 'value', 'dateHour', 'comment'
    ];

    public function seller()
    {
        return $this->belongsTo('App\Models\Person', 'winnerID')->withPivot('value', 'dateHour', 'comment');
    }

    public function rated()
    {
        return $this->belongsToMany('App\Models\Car', 'autionID')->withPivot('value', 'dateHour', 'comment');
    }
}
