<?php

use App\Http\Controllers\AddressController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\FindSpecialistController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\PhoneController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\SpecialistViewController;
use App\Http\Controllers\UserDashboardController;
use App\Models\Category;
use App\Models\ServiceKind;
use App\Models\Specialist;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

// Route::get('/', function () {
//     return Inertia::render('Welcome', [
//         'canLogin' => Route::has('login'),
//         'canRegister' => Route::has('register'),
//         'laravelVersion' => Application::VERSION,
//         'phpVersion' => PHP_VERSION,
//     ]);
// });
Route::get('/', function () {
    return Inertia::render('Home');
})->name('home');
Route::get('/dla-dietetykow', function () {
    return Inertia::render('Guest/AboutDieteticians');
})->name('about.dietician');

Route::get('/dla-pacjentow', function () {
    return Inertia::render('Guest/ForUsers');
})->name('about.client');
Route::get('/tablica', UserDashboardController::class)->middleware(['auth', 'verified'])->name('dashboard');
Route::get('/specjalisci',[FindSpecialistController::class, 'unregisteredUserFind'])->name('guest.specialist.index');

Route::middleware('auth')->group(function () {
    Route::get('/profil', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::post('/address',[AddressController::class,'store'])->name('address.store');
    Route::put('/address/{address}',[AddressController::class,'update'])->name('address.update');
    Route::delete('/address/{address}',[AddressController::class,'destroy'])->name('address.remove');

    Route::get('/znajdz-specialiste',[FindSpecialistController::class, 'find'])->name('specialist.index');
    
    //fn () => Inertia::render('FindSpecialist',['categories'=>Category::all(),'services'=>ServiceKind::all()])
    Route::get('/specjalista/{specialist}', [SpecialistViewController::class, 'user'])->name('specialist.visit');
    Route::patch('/specialist/booking/{booking}/reserve', [BookingController::class, 'reserveBooking'])->name('bookings.reserve');
    Route::get('/specjalista/{specialist}/rezerwacje',[BookingController::class, 'showSpecialistReservationPage'])->name('user.book.specialist');
    Route::get('/wizyty',[BookingController::class, 'index'])->name('user.bookings.index');

    Route::post('/review/specialist/{specialist}',[ReviewController::class,'store'])->name('review.store');
    Route::put('/review/{review}',[ReviewController::class, 'update'])->name('review.update');
    Route::delete('/review/{review}',[ReviewController::class,'destroy'])->name('review.destroy');

    Route::patch('/notification/{notificationId}',[NotificationController::class, 'userNotificationMarkAsRead'])->name('specialist.notification.mark');
    Route::put('/phone/{phone}',[PhoneController::class,'update'])->name('phone.update');
});


//Anonym
Route::get('anonym/specjalista/{specialist}/rezerwacje',[BookingController::class, 'showSpecialistReservationPageForAnonym'])
->name('guest.book.specialist');
Route::get('/dietetyk/{specialist}', [SpecialistViewController::class, 'guest'])->name('guest.specialist.visit');
Route::patch('anonym/specialist/booking/{booking}/reserve', [BookingController::class, 'reserveBookingForAnonym'])
->name('guest.bookings.reserve');
Route::get('/dolacz-do-nas/{specialist}', function (Specialist $specialist) {
    return Inertia::render('Guest/MaybeLogin',['specialist'=>$specialist]);
})->name('maybe.login');
//END Anonym

Route::prefix('payment')->group(
function (){
    Route::post('notifications',[PaymentController::class,'notify']);
}
);

require __DIR__.'/auth.php';
require __DIR__.'/specialist.php';