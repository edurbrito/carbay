<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use Notifiable;

    public $timestamps  = false;
    protected $table = 'Report';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'reason', 'dateHour', 'reporterID', 'locationAuctionID', 'locationCommentID', 'locationRegisteredID', 'stateType'
    ];
}
