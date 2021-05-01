<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use Notifiable;

    public $timestamps  = false;
    protected $table = 'Notification';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'viewed', 'dateHour', 'recipientID', 'contextRating', 'contextHelpMessage', 'contextFavSeller', 'contextBid', 'contextFavAuction'
    ];
}
