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
        'id', 'title', 'description', 'startingprice', 'highestbid', 'startdate', 'finaldate', 'suspend', 'buynow', 'scaletype', 'brandid', 'colourid', 'sellerid', 'search'
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
        return $this->hasMany(Bid::class, 'auctionid')->orderBy('value', 'desc');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class, 'auctionid')->orderBy('datehour', 'desc');
    }

    public function first_image()
    {
        return $this->images->first();
    }

    public function time_remaining()
    {
        date_default_timezone_set("Europe/Lisbon");

        $now = date('Y-m-d H:i:s');
        $date = date('Y-m-d H:i:s', strtotime($this->finaldate));
        $now = new DateTime($now);
        $date = new DateTime($date);
        if($now > $date)
            return "Ended";
        return date_diff($now,$date)->format("%ad %hh %im %ss");
    }

    public function highest_bid()
    {
        return $this->bids->first();
    }

    public function rating_value()
    {
        $rating = $this->hasOne(Rating::class, 'auctionid')->first();
        if (isset($rating))
            return $rating->value;
        else
            return 0;
    }

    public function rating()
    {
        return $this->hasOne(Rating::class, 'auctionid')->first();
    }

    public function brand_name()
    {
        return $this->brand->name;
    }

    public function colour_name()
    {
        return $this->colour->name;
    }

    public function seller_username()
    {
        return $this->seller->username;
    }

    public function highest_bid_value()
    {
        $bid = $this->highestbid;
        $value = !is_null($bid) ? $bid . "$" : "None";
        return $value;
    }

    public function buy_now()
    {
        return $this->buynow . "$";
    }

    public function description()
    {
        return $this->description;
    }

    public function display_images()
    {
        return $this->images;
    }
}
