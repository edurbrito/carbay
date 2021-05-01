<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use Notifiable;

    public $timestamps  = false;
    protected $table = 'image';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'url', 'auctionid'
    ];

    public function images()
    {
        return $this->belongsTo('App\Models\Auction', 'auctionid');
    }
}
