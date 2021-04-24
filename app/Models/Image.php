<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use Notifiable;

    public $timestamps  = false;
    protected $table = 'Image';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'url', 'auctionID'
    ];

    public function images()
    {
        return $this->belongsTo('App\Models\Auction', 'auctionID');
    }
}
