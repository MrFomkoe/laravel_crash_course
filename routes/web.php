<?php

use App\Http\Controllers\ListingController;
use App\Http\Controllers\UserController;
use App\Models\Listing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


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



/* Work with routes */

// Route::get('/hello', function () {
//     return response('<h1>Hello World!</h1>', 200)
//         ->header('Content-Type', 'text/plain');
// });


// // Using query parameter and add constraints
// Route::get('/posts/{id}', function ($id) {
//     return response('Post' . $id);
    
// })->where('id', '[0-9]+'); // Constraint

// // Request paramenters through debugger

// Route::get('/search', function(Request $request) {
//     dd($request->name . ' ' . $request->city);
// });

/* Start of work on project */

/* Naming convention for routes/methods */
// index - Show all units
// show - Show single unit
// create - Show form to create new unit
// store - Store new unit
// edit - Show form for edit unit
// update - Update unit
// destroy - Delete unit


// Show create form
Route::get('/listings/create', [ListingController::class, 'create'])->middleware('auth');

// Store listing data in database
Route::post('/listings', [ListingController::class, 'store'])->middleware('auth');

// All listings
Route::get('/', [ListingController::class, 'index']);

// Show edit form
Route::get('/listings/{listing}/edit', [ListingController::class, 'edit'])->middleware('auth');

// Update listing
Route::put('/listings/{listing}', [ListingController::class, 'update'])->middleware('auth');

// Delete listing
Route::delete('/listings/{listing}', [ListingController::class, 'destroy'])->middleware('auth');

// Manage user listings
Route::get('/listings/manage', [ListingController::class, 'manage'])->middleware('auth');

// Single listing together with in-built check 
// THIS HAS TO BE LOWER THAN ANYTHING ELSE
Route::get('/listings/{listing}', [ListingController::class, 'show']);

// Show register create form
Route::get('/register', [UserController::class, 'create'])->middleware('guest');

// Create new user
Route::post('/users', [UserController::class, 'store']);

// Log user out
Route::post('/logout', [UserController::class, 'logout'])->middleware('auth');

// Show login form
Route::get('/login', [UserController::class, 'login'])->name('login')->middleware('guest');

// Log in user
Route::post('/users/authenticate', [UserController::class, 'authenticate']);
