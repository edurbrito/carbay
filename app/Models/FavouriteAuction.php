<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

class FavouriteAuction extends Model
{
    use Notifiable;

    // Don't add create and update timestamps in database.
    public $timestamps  = false;
    protected $table = 'FavouriteAuction';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user1ID', 'user2ID'
    ];

    public function owner()
    {
        return $this->belongsToMany('App\Models\User', 'userID');
    }
}
