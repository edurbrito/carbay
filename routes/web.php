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

// Cards
Route::get('cards', 'CardController@list');
Route::get('cards/{id}', 'CardController@show');

// API
Route::put('api/cards', 'CardController@create');
Route::delete('api/cards/{card_id}', 'CardController@delete');
Route::put('api/cards/{card_id}/', 'ItemController@create');
Route::post('api/item/{id}', 'ItemController@update');
Route::delete('api/item/{id}', 'ItemController@delete');

// Authentication
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::get('logout', 'Auth\LoginController@logout')->name('logout');
Route::get('signup', 'Auth\RegisterController@showRegistrationForm')->name('signup');
Route::post('signup', 'Auth\RegisterController@register');

// Search
Route::get('/auctions/search', 'AuctionController@index');
Route::get('api/auctions/search', 'AuctionController@search');

Route::get('api/colours', 'ColourController@index');
Route::get('api/brands', 'BrandController@index');
Route::get('api/scales', 'AuctionController@scales');
Route::get('api/sellers', 'UserController@sellers');

// Auction
Route::get('auctions/create', 'AuctionController@create_page');
Route::post('auctions/create', 'AuctionController@create');
Route::get('auctions/{id}', 'AuctionController@show');