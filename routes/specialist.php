<?php

use App\Http\Controllers\AddressController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\ServiceCityController;
use App\Http\Controllers\SpecialistController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\DescriptionController;
use App\Http\Controllers\IconController;
use App\Http\Controllers\PriceController;
use App\Http\Controllers\ServiceController;

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Inertia\Response;

Route::middleware(["auth", "spec"])->group(function () {
    Route::post("/specjalist", [SpecialistController::class, 'store'])->WithoutMiddleware('spec')->name('specialist.store');
    Route::get("/utworz-specjaliste", [SpecialistController::class, 'create'])->WithoutMiddleware('spec')->name('specialist.create');
    Route::post('/specialist/{specialist}/address', [AddressController::class, 'storeForSpecialist'])->name('specialist.address.store');
    Route::get('/specjalista/address', [AddressController::class, 'index'])->name('specialist.address.create');
    Route::delete('/specialist/{specialist}', [SpecialistController::class, 'destroy'])->name('specialist.remove');

    Route::get('/twoje-szkolenia',[CourseController::class,'create' ])->name('course.create');

    Route::get('/wybierz-kategorie', [CategoryController::class, 'specialistCategoriesForm'])->name('category.attach');
    Route::post('/specialist/{specialist}/categories', [CategoryController::class, 'attachCategoriesToSpecialist'])->name('specialist.categories.store');
    Route::put('/specialist/{specialist}/categories', [CategoryController::class, 'updateSpecialistCategories'])->name('specialist.categories.update');

    Route::get('/wybierz-miejsce-uslugi', [ServiceController::class, 'index'])->name('service.form');
    Route::post('/specialist/{specialist}/services', [ServiceController::class, 'store'])->name('store.services');

    Route::get("/specjalista/tablica", function (): Response {
        return Inertia::render('Specialist/SpecialistDashboard');
    })->name('specialist.dashboard');

    Route::post('/specialist/{specialist}/address', [AddressController::class, 'storeForSpecialist'])->name('specialist.address.store');
});

Route::middleware(["auth", "spec"])->group(function () {
    Route::put('/specialist/{specialist}', [SpecialistController::class, 'update'])->name('specialist.profile.update');
    Route::put('/specialist/{specialist}/address/{address}', [AddressController::class, 'updateForSpecialist'])->name('specialist.address.update');
    Route::get('/specjalista/{specialist}/profil', [SpecialistController::class, 'edit'])->name('specialist.profile.edit');
    Route::post('/specialist/{specialist}/address/new', [AddressController::class, 'storeForSpecialistAndRedirectBack'])->name('specialist.address.store.new');

    Route::delete('/specialist/serviceCity/{serviceCity}',[ServiceCityController::class,'destroy'])->name('specialist.serviceCity.delete');
    Route::put('/specialist/{specialist}/services', [ServiceController::class, 'update'])->name('update.services');

    Route::post('/specialist/{specialist}/price',[PriceController::class, 'store'])->name('specialist.price.store');
    Route::delete('/specialist/{specialist}/price/{price}',[PriceController::class, 'destroy'])->name('specialist.price.delete');
    Route::put('/specialist/{specialist}/price/{price}',[PriceController::class, 'update'])->name('specialist.price.update');
    
});
Route::middleware(["auth", "spec"])->group(function () {
    Route::post('/specialist/{specialist}/avatar',[SpecialistController::class, 'storeAvatar'])->name('avatar.store');
    Route::post('/specialist/{specialist}/icon',[IconController::class, 'store'])->name('icon.store');
    Route::delete('icon/{icon}',[IconController::class, 'destroy'])->name('icon.delete');

    Route::post('/specialist/{specialist}/description',[DescriptionController::class, 'store'])->name('description.store');
    Route::put('/specialist/{specialist}/description/{description}',[DescriptionController::class, 'update'])->name('description.update');
    Route::delete('/description/{description}',[DescriptionController::class, 'destroy'])->name('description.destroy');

    Route::get('/specialista/wizyty/stworz-wizyte', [BookingController::class, 'create'])->name('specialist.setMeetings');

    Route::post('/specialist/{specialist}/bookings', [BookingController::class, 'store'])->name('bookings.store');
    Route::delete('/specialist/{specialist}/booking/{booking}', [BookingController::class, 'destroy'])->name('bookings.destroy');

    Route::patch('/specialist/booking/{booking}', [BookingController::class, 'changeStatus'])->name('bookings.status');
   
});

Route::middleware(["auth", "spec"])->group(function () {
    Route::post('/specialist/{specialist}/course',[CourseController::class, 'store'])->name('course.store');
    Route::put('/course/{course}',[CourseController::class, 'update'])->name('course.update');
    Route::delete('/course/{course}',[CourseController::class, 'destroy'])->name('course.destroy');
});