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
Route::get('auctions/search', 'AuctionController@index');

Route::get('api/auctions/search', 'AuctionController@search');
Route::get('api/colours', 'ColourController@index');
Route::get('api/brands', 'BrandController@index');
Route::get('api/scales', 'AuctionController@scales');
Route::get('api/sellers', 'UserController@sellers');

// Auction
Route::get('auctions/create', 'AuctionController@create_page');
Route::post('auctions/create', 'AuctionController@create');
Route::get('auctions/{id}', 'AuctionController@show');
Route::post('auctions/{id}/bids', 'BidController@create');

Route::get('api/auctions/featured', 'AuctionController@featured');
Route::get('api/auctions/{id}/bids', 'AuctionController@bids');
Route::get('api/auctions/{id}/comments', 'AuctionController@comments');
Route::post('api/auctions/{id}/comments', 'CommentController@create');

// Profile
Route::get('users/{username}', 'UserController@show');
Route::get('api/users/{username}/bids', 'UserController@bids');
Route::get('api/users/{username}/auctions', 'UserController@auctions');
Route::get('api/users/{username}/fav_auctions', 'UserController@fav_auctions');
Route::get('api/users/{username}/fav_sellers', 'UserController@sellers');
Route::get('api/users/{username}/ratings', 'UserController@ratings');
Route::get('api/users/{username}/rated', 'UserController@rated');
Route::get('users/{username}/edit', 'UserController@edit_profile');
Route::post('users/{username}/edit', 'UserController@edit');