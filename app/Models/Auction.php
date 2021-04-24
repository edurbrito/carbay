<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Auction extends Model
{
    use HasFactory;

    // Don't add create and update timestamps in database.
    public $timestamps  = false;
    protected $table = 'Auction';

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
        return $this->belongsTo(Brand::class, 'brandID');
    }

    public function colour()
    {
        return $this->belongsTo(Colour::class, 'colourID');
    }

    public function images()
    {
        return $this->hasMany(Image::class, 'auctionID');
    }

    public function seller()
    {
        return $this->belongsTo(User::class, 'sellerID');
    }

    public function bid()
    {
        return $this->hasMany(Bid::class, 'auctionID');
    }
}
