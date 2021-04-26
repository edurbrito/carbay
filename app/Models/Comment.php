<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use Notifiable;

    public $timestamps  = false;
    protected $table = 'comment';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'text', 'dateHour', 'authorID', 'auctionID'
    ];

    public function comments()
    {
        return $this->belongsTo('App\Models\Auction', 'auctionid');
    }

    public function author()
    {
        return $this->belongsTo('App\Models\User', 'authorid');
    }
}
