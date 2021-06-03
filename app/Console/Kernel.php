<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use App\Models\FavouriteAuction;
use App\Models\Auction;
use App\Models\Notification;
use Illuminate\Support\Facades\Log;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->call(function () {
            $auctions = FavouriteAuction::join('auction', 'auctionid', '=', 'auction.id')->whereRaw('auction.finaldate > NOW() AND auction.finaldate < (NOW() + INTERVAL \'10 minute\')')->select('userid', 'auctionid', 'title')->get();
            foreach ($auctions as $auction){
                try{
                    $notification = new Notification();
                    $notification->recipientid = $auction['userid'];
                    $notification->contextfavauction = $auction['auctionid'];
                    $notification->save();
                } catch (\Throwable $th) {

                }
            }

            $auctions = Auction::whereRaw('finaldate < NOW()')->get();
            foreach ($auctions as $auction){
                try{
                    $notification = new Notification();
                    $notification->recipientid = $auction['sellerid'];
                    $notification->contextrate = $auction['id'];
                    $notification->save();

                    $notification = new Notification();
                    $notification->recipientid = $auction->highest_bid()->authorid;
                    $notification->contextrate = $auction['id'];
                    $notification->save();

                    Mail::send('emails.rate', ['auction' => $auction], function($message) use($auction)
                    {
                        $message->to($auction->highest_bid()->author->email, $auction->highest_bid()->author->name)->subject('Congratulations! You won an auction in CarBay!');
                    });

                } catch (\Throwable $th) {

                }
            }

        })->everyMinute();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
