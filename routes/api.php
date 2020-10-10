<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

// room
Route::get('rooms', 'RoomController@allrooms');
Route::get('room/{room}', 'RoomController@roomdetail');
Route::post('createroom', 'RoomController@createroom');
Route::put('room/{id}', 'RoomController@updateroom');
Route::delete('room/{id}', 'RoomController@destroyroom');


// table
Route::get('tables', 'RoomController@alltable');
Route::get('table/{table}', 'RoomController@tabledetail');
Route::post('createtable', 'RoomController@createtable');
Route::put('table/{id}', 'RoomController@updatetable');
Route::delete('table/{id}', 'RoomController@destroytable');


//event
Route::get('events', 'RoomController@alltevent');
Route::post('createevent', 'RoomController@createevent');
Route::get('event/{event}', 'RoomController@eventdetail');



//booking
Route::get('bookings', 'BookingController@allbooking');
Route::get('booking/{booking}', 'BookingController@bookingdetail');
Route::post('createbooking', 'BookingController@createbooking');

//shop information
Route::get('shops', 'BookingController@listshop');
Route::get('shop/{shop}', 'BookingController@shopdetail');
Route::get('shoproomdetail/{shoproomdetail}','BookingController@shoproomdetail');
Route::get('shoptabledetail/{shoptabledetail}','BookingController@shoptabledetail');
Route::get('shopeventdetail/{shopeventdetail}','BookingController@shopeventdetail');



//user's booking history
Route::get('users', 'BookingController@listalluser');
Route::get('user/{user}', 'BookingController@userbookinghistory');


//shop's booking history
Route::get('shopbookinghistory/{shopbookinghistory}', 'BookingController@shopbookinghistory');
//seller respone
Route::put('booking/{id}', 'BookingController@updatebookingstatus');
// Route::put('table/{id}', 'RoomController@updatetable');


//doctor
Route::get('doctors', 'AppointmentsController@alldoctor');
Route::get('doctor/{doctor}', 'AppointmentsController@doctordetail');
Route::put('createdoctor/{id}', 'AppointmentsController@updatedoctor');
Route::post('createdoctor', 'AppointmentsController@createdoctor');
Route::delete('doctor/{id}', 'AppointmentsController@destroydoctor');



//hospital
Route::get('hospitals', 'AppointmentsController@allhospital');
Route::get('hospital/{hospital}', 'AppointmentsController@hospitaldetail');




//user appointments history
Route::get('userappointmenthistorys/{userappointmenthistorys}', 'AppointmentsController@userappointmenthistory');
// Route::get('user/{user}', 'AppointmentsController@userappointmenthistory');

//appointment
Route::post('createappointment', 'AppointmentsController@createappointment');
Route::get('appointments', 'AppointmentsController@allappointment');
Route::get('appointment/{appointment}', 'AppointmentsController@appointmentdetail');
Route::put('appointment/{id}', 'AppointmentsController@cancelledappointment');


//hospital appointment history
Route::get('hospitalappointmenthistory/{hospitalappointmenthistory}', 'AppointmentsController@hospitalappointmenthistory');


//floor 
Route::post('createfloor', 'RoomController@createfloor');
Route::get('floor/{floor}', 'RoomController@floordetail');
Route::get('floors', 'RoomController@allfloor');
Route::put('floor/{id}', 'RoomController@updatefloor');
Route::delete('floor/{id}','RoomController@destroyfloor');


//bookingItem
// Route::post('createbookingItem', 'BookingController@createbookingItem');
Route::get('bookingitems', 'BookingController@listallbookingitem');
Route::get('bookingitem/{bookingitem}', 'BookingController@bookingitemdetail');


//service
Route::post('createservice', 'AppointmentsController@createservice');
// Route::get('services', 'AppointmentsController@allspecialist');
// Route::get('skill/{skill}', 'AppointmentsController@specialistdetail');
// Route::put('skill/{id}', 'AppointmentsController@updatespecialist');
// Route::delete('skill/{id}','AppointmentsController@destroyspecialist');

//bookingList

Route::post('createbookingList', 'BookingController@createbookingList');
Route::get('bookinglists', 'BookingController@allbookinglist');
Route::get('bookinglist/{bookinglist}', 'BookingController@bookinglistdetail');

