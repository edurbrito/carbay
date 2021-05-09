<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

class FavouriteSeller extends Model
{
    use Notifiable;

    public $timestamps  = false;
    protected $table = 'favouriteseller';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'user1id', 'user2id'
    ];
}
