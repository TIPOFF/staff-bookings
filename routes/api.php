<?php

use Illuminate\Support\Facades\Route;

Route::post('/{location:slug}/checkout', 'Tipoff\StaffBookings\Http\Controllers\CheckoutController@store');
Route::get('/locations/{location:slug}', 'Tipoff\StaffBookings\Http\Controllers\LocationsController@show');
Route::post('/{location:slug}/contact-details', 'Tipoff\StaffBookings\Http\Controllers\ContactDetailsController@store');
Route::post('/{user:id}/add-code', 'Tipoff\StaffBookings\Http\Controllers\CartsController@addCode');
Route::get('/users/{user:id}/cart', 'Tipoff\StaffBookings\Http\Controllers\CartsController@show');
Route::post('/users/{user:id}/cart-items', 'Tipoff\StaffBookings\Http\Controllers\CartItemsController@store');
Route::delete('/cart-items/{cartItem:id}', 'Tipoff\StaffBookings\Http\Controllers\CartItemsController@destroy');
