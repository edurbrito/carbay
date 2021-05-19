<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use Notifiable;

    public $timestamps  = false;
    protected $table = 'notification';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'viewed', 'datehour', 'recipientid', 'contextrating', 'contexthelpmessage', 'contextfavseller', 'contextbid', 'contextfavauction'
    ];

    public function recipient()
    {
        return $this->belongsTo(User::class, 'recipientid');
    }

    public function rating()
    {
        return $this->belongsTo(Auction::class, 'contextrating');
    }

    public function fav_seller()
    {
        return $this->belongsTo(Auction::class, 'contextfavseller');
    }

    public function bid()
    {
        return $this->belongsTo(Auction::class, 'contextbid');
    }

    public function fav_auction()
    {
        return $this->belongsTo(Auction::class, 'contextfavauction');
    }
}
