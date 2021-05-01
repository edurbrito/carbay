<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

class Colour extends Model
{
    use Notifiable;

    public $timestamps  = false;
    protected $table = 'colour';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name'
    ];

    public function auctions()
    {
        return $this->hasMany('App\Models\Auction');
    }
}
