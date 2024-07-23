<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HighLevelController;

Route::get('/', function () {
    return view('home');
});

Route::get('/oauth/authorize', [HighLevelController::class, 'redirectToAuthorization'])->name('oauth.authorize');
Route::get('/oauth/callback', [HighLevelController::class, 'handleCallback'])->name('oauth.callback');
Route::get('/error', function () {
    return view('error', ['message' => session('message')]);
});
Route::get('/contacts', [HighLevelController::class, 'fetchContacts'])->name('contacts');
Route::get('/conversations', [HighLevelController::class, 'fetchConversations'])->name('conversations');



// Fleetbase API,s

//  Orders done
Route::get('/orders', [App\Http\Controllers\OrderController::class, 'index']);// All recode  
Route::get('/orders/{id}', [App\Http\Controllers\OrderController::class, 'show']); // Show single recode 
Route::get('orders-add', [App\Http\Controllers\OrderController::class, 'create']); // Add data 
Route::get('orders-upd/{id}', [App\Http\Controllers\OrderController::class, 'update']); // Update data
Route::get('orders-del/{id}', [App\Http\Controllers\OrderController::class, 'delete']); // Delete data



// Store Locations done
Route::get('place', [App\Http\Controllers\PlaceController::class, 'index']); // All recode 
Route::get('place/{id}', [App\Http\Controllers\PlaceController::class, 'show']); // Show single recode 
Route::get('place-add', [App\Http\Controllers\PlaceController::class, 'create']); // Add data 
Route::get('place-upd/{id}', [App\Http\Controllers\PlaceController::class, 'update']); // Update data
Route::get('places-del/{id}', [App\Http\Controllers\PlaceController::class, 'delete']); // Delete data


// Contact done
Route::get('contact', [App\Http\Controllers\HighLevelContactController::class, 'index']); // All recode 
Route::get('contact/{id}', [App\Http\Controllers\HighLevelContactController::class, 'show']); // Show single recode 
Route::get('contacts-add', [App\Http\Controllers\HighLevelContactController::class, 'create']);  // Add data 
Route::get('contacts-upd/{id}', [App\Http\Controllers\HighLevelContactController::class, 'update']); // Update data
Route::get('contacts-del/{id}', [App\Http\Controllers\HighLevelContactController::class, 'destroy']);  // Delete data
 

// Payload done
Route::get('payload', [App\Http\Controllers\HighLevelPayloadController::class, 'index']);  // All recode 
Route::get('payload/{id}', [App\Http\Controllers\HighLevelPayloadController::class, 'show']); // Show single recode 
Route::get('payload-add', [App\Http\Controllers\HighLevelPayloadController::class, 'create']); // Add data
Route::get('payload-upd/{id}', [App\Http\Controllers\HighLevelPayloadController::class,'update']); // Update data
Route::get('payloads-del/{id}', [App\Http\Controllers\HighLevelPayloadController::class, 'delete']); // Delete data

// Entity done
Route::get('entity', [App\Http\Controllers\EntityController::class, 'index']); // All recode 
Route::get('entity/{id}', [App\Http\Controllers\EntityController::class, 'show']); // Show single recode 
Route::get('/create-entity', [App\Http\Controllers\EntityController::class, 'createEntity']); // Add data 
Route::get('entities-upd/{id}', [App\Http\Controllers\EntityController::class, 'update']); // Update data
Route::get('/entities/{id}', [App\Http\Controllers\EntityController::class, 'deleteEntity']); // Delete data


// Service-areas done
Route::get('service-areas', [App\Http\Controllers\ServiceAreaController::class, 'index']); // All recode 
Route::get('service-areas/{id}', [App\Http\Controllers\ServiceAreaController::class, 'show']); // Show single recode 
Route::get('service-area-add', [App\Http\Controllers\ServiceAreaController::class, 'create']); // Add data 
Route::get('service-areas-upd/{id}', [App\Http\Controllers\ServiceAreaController::class, 'update']); // Update data
Route::get('/service-areas-del/{id}', [App\Http\Controllers\ServiceAreaController::class, 'delete']); // Delete data


// Zones done
Route::get('/zones', [App\Http\Controllers\ZoneController::class, 'index']); // All recode 
Route::get('/zones/{id}', [App\Http\Controllers\ZoneController::class, 'show']); // Show single recode 
Route::get('/zones-add', [App\Http\Controllers\ZoneController::class, 'create']); // Add data 
Route::get('zones-upd/{id}', [App\Http\Controllers\ZoneController::class, 'update']); // Update data
Route::get('zones-del/{id}', [App\Http\Controllers\ZoneController::class, 'delete']); // Delete data



// Drivers done
Route::get('/drivers', [App\Http\Controllers\DriverController::class, 'index']); // All recode 
Route::get('/drivers/{id}', [App\Http\Controllers\DriverController::class, 'show']); // Show single recode 
Route::get('/driver-add', [App\Http\Controllers\DriverController::class, 'createDriver']); // Add data 
Route::get('drivers-upd/{id}', [App\Http\Controllers\DriverController::class, 'updateDriver']); // Update data
Route::get('drivers-del/{id}', [App\Http\Controllers\DriverController::class, 'deleteDriver']); // Delete data


// Fleet done
Route::get('fleets', [App\Http\Controllers\FleetController::class, 'listFleets']); // All recode 
Route::get('fleets/{id}', [App\Http\Controllers\FleetController::class, 'getFleet']); // Show single recode 
Route::get('fleets-add', [App\Http\Controllers\FleetController::class, 'createFleet']); // Add data 
Route::get('fleets-upd/{id}', [App\Http\Controllers\FleetController::class, 'updateFleet']); // Update data
Route::get('fleets-del/{id}', [App\Http\Controllers\FleetController::class, 'deleteFleet']); // Delete data


// Vehicle done
Route::get('vehicles', [App\Http\Controllers\VehicleController::class, 'listVehicles']); // All recode 
Route::get('vehicles/{id}', [App\Http\Controllers\VehicleController::class, 'getVehicle']); // Show single recode 
Route::get('vehicles-add', [App\Http\Controllers\VehicleController::class, 'createVehicle']); // Add data 
Route::get('vehicles-upd/{id}', [App\Http\Controllers\VehicleController::class, 'updateVehicle']); // Update data
Route::get('vehicles-del/{id}', [App\Http\Controllers\VehicleController::class, 'deleteVehicle']); // Delete data

// Service rates Done
Route::get('service-rates', [App\Http\Controllers\FleetbaseServiceRateController::class, 'list']);
Route::get('service-rates/{id}', [App\Http\Controllers\FleetbaseServiceRateController::class, 'get']);
Route::get('service-rates-add', [App\Http\Controllers\FleetbaseServiceRateController::class, 'create']);
Route::get('service-rates-upd/{id}', [App\Http\Controllers\FleetbaseServiceRateController::class, 'update']);
Route::get('service-rates-del/{id}', [App\Http\Controllers\FleetbaseServiceRateController::class, 'delete']);

// purchase rates Done
Route::get('purchase-rates', [App\Http\Controllers\PurchaseController::class, 'create']); // All recode
Route::get('purchase-rates/{id}', [App\Http\Controllers\PurchaseController::class, 'show']); // Show single recode 
Route::get('purchase-rates-add', [App\Http\Controllers\PurchaseController::class, 'index']); // Add data 
Route::get('purchase-rates-upd/{id}', [App\Http\Controllers\PurchaseController::class, 'update']); // Update data
Route::get('purchase-rates-del/{id}', [App\Http\Controllers\PurchaseController::class, 'destroy']); // Delete data 


// Tracking Numbers done
Route::get('tracking-numbers', [App\Http\Controllers\TrackingController::class, 'index']); // All recode
Route::get('tracking-numbers/{id}', [App\Http\Controllers\TrackingController::class, 'show']); // Show single recode 
Route::get('tracking-numbers-add', [App\Http\Controllers\TrackingController::class, 'create']); // Add data
Route::get('tracking-numbers-upd/{id}', [App\Http\Controllers\TrackingController::class, 'update']); // Update data
Route::get('tracking-numbers-del/{id}', [App\Http\Controllers\TrackingController::class, 'destroy']); // Delete data

// Tracking Status done
Route::get('tracking-statuses', [App\Http\Controllers\TrackingStatusController::class, 'index']); // All recode
Route::get('tracking-statuses/{id}', [App\Http\Controllers\TrackingStatusController::class, 'show']); // Show single recode 
Route::get('tracking-statuses-add', [App\Http\Controllers\TrackingStatusController::class, 'create']); // Add data
Route::get('tracking-statuses-upd/{id}', [App\Http\Controllers\TrackingStatusController::class, 'update']); // Update data
Route::get('tracking-statuses-del/{id}', [App\Http\Controllers\TrackingStatusController::class, 'destroy']); // Delete data