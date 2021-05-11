<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
// Home
Route::get('/', 'StaticController@home');
// About
Route::get('/about', 'StaticController@about');
// FAQs
Route::get('/faqs', 'StaticController@faqs');

// Authentication
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::get('logout', 'Auth\LoginController@logout')->name('logout');
Route::get('signup', 'Auth\RegisterController@showRegistrationForm')->name('signup');
Route::post('signup', 'Auth\RegisterController@register');

// Search
Route::get('auctions/search', 'StaticController@search');

Route::get('api/auctions/search', 'AuctionController@search');
Route::get('api/colours', 'ColourController@index');
Route::get('api/brands', 'BrandController@index');
Route::get('api/scales', 'AuctionController@scales');
Route::get('api/sellers', 'UserController@sellers');

// Auction
Route::get('api/auctions','AuctionController@index');
Route::get('auctions/create', 'AuctionController@create');
Route::post('auctions/create', 'AuctionController@store');
Route::get('auctions/{id}', 'AuctionController@show');
Route::post('auctions/{id}/bids', 'BidController@store');

Route::get('api/auctions/featured', 'AuctionController@featured');
Route::get('api/auctions/{id}/bids', 'BidController@index');
Route::get('api/auctions/{id}/comments', 'CommentController@index');
Route::post('api/auctions/{id}/comments', 'CommentController@store');

// Profile
Route::get('users/{username}', 'UserController@show');
Route::get('api/users/{username}/bids', 'UserController@bids');
Route::get('api/users/{username}/auctions', 'UserController@auctions');
Route::get('api/users/{username}/fav_auctions', 'UserController@fav_auctions');
Route::get('api/users/{username}/fav_sellers', 'UserController@fav_sellers');
Route::get('api/users/{username}/ratings', 'UserController@ratings');
Route::get('api/users/{username}/rated', 'UserController@rated');
Route::get('users/{username}/edit', 'UserController@edit'); // TODO: username
Route::post('users/{username}/edit', 'UserController@update');
Route::delete('users/{username}/delete', 'UserController@destroy');

// User
Route::get('api/users','UserController@index');
Route::post('api/users/fav_sellers/add', 'FavouriteSellerController@store');
Route::post('api/users/fav_sellers/remove', 'FavouriteSellerController@destroy');
Route::post('api/users/fav_auctions/add', 'FavouriteAuctionController@store');
Route::post('api/users/fav_auctions/remove', 'FavouriteAuctionController@destroy');

// Admin
Route::get('admin','UserController@admin');
Route::post('admin/make/{username}','UserController@make_admin');
Route::post('admin/ban/{username}','UserController@ban');