<?php

namespace App\Models;

use DateTime;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Auction extends Model
{
    use HasFactory;

    // Don't add create and update timestamps in database.
    public $timestamps  = false;
    protected $table = 'auction';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'title', 'description', 'startingPrice', 'startDate', 'finalDate', 'suspend', 'buyNow', 'scaleType', 'brandID', 'colourID', 'sellerID', 'search'
    ];

    public function brand()
    {
        return $this->belongsTo(Brand::class, 'brandid');
    }

    public function colour()
    {
        return $this->belongsTo(Colour::class, 'colourid');
    }

    public function images()
    {
        return $this->hasMany(Image::class, 'auctionid');
    }

    public function seller()
    {
        return $this->belongsTo(User::class, 'sellerid');
    }

    public function bids()
    {
        return $this->hasMany(Bid::class, 'auctionid');
    }

    public function first_image()
    {
        return $this->images->first();
    }

    public function time_remaining()
    {
        date_default_timezone_set("Europe/Lisbon");
        
        $now = new DateTime();
        $date = new DateTime($this->finaldate);
        
        return $date->diff($now)->format("%ad %hh %im %ss");
    }

    public function highest_bid()
    {
        return $this->bids->last();
    }

    public function rating()
    {
        $rating = $this->hasOne(Rating::class, 'auctionid')->first();
        if(isset($rating))
            return $rating->value;
        else
            return 0;
    }
}
