<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use Notifiable;

    public $timestamps  = false;
    protected $table = 'report';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'reason', 'datehour', 'reporterid', 'locationauctionid', 'locationcommentid', 'locationregisteredid', 'statetype', 'reportedid'
    ];

    public function location()
    {
        if (!is_null($this->locationauctionid))
            return ["location" => "Auction", "url" => "/auctions/" . $this->locationauctionid];
        else if (!is_null($this->locationcommentid))
            return ["location" => "Comment", "url" => "/auctions/" . Comment::find($this->locationcommentid)->auction->id];
        else if (!is_null($this->locationregisteredid))
            return ["location" => "Profile", "url" => "/users/" . User::find($this->locationregisteredid)->username];
    }

    public function reported()
    {
        if (!is_null($this->locationauctionid))
            return Auction::find($this->locationauctionid)->seller;
        else if (!is_null($this->locationcommentid))
            return Comment::find($this->locationcommentid)->author;
        else if (!is_null($this->locationregisteredid))
            return User::find($this->locationregisteredid);
    }
    
    public function rdate()
    {
        $matches = null;
        if(preg_match('/.+(?=:)/', $this->datehour, $matches))
            return $matches[0];

        return $this->datehour;
    }
}
