<?php

use App\Enums\SocialMedia;
use App\Http\Controllers\AddressController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ServiceCityController;
use App\Http\Controllers\ShowOffersController;
use App\Http\Controllers\SocialMediaController;
use App\Http\Controllers\SpecialistController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\DescriptionController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\FavouritePriceController;
use App\Http\Controllers\IconController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\PriceController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\SpecialistDashboardController;
use App\Http\Controllers\SpecialistPaymentMethodsController;
use App\Models\Specialist;
use Illuminate\Support\Facades\Route;

Route::middleware(["auth", "spec"])->group(function () {
    Route::post("/specialist", [SpecialistController::class, 'store'])->WithoutMiddleware('spec')->name('specialist.store');
    Route::get("/utworz-specjaliste", [SpecialistController::class, 'create'])->WithoutMiddleware('spec')->name('specialist.create');

    Route::post('/specialist/{specialist}/address', [AddressController::class, 'storeForSpecialist'])->name('specialist.address.store');
    Route::get('dla-specjalisty/specjalista/address', [AddressController::class, 'create'])->name('specialist.address.create');
    Route::delete('/specialist/{specialist}', [SpecialistController::class, 'destroy'])->name('specialist.remove');

    Route::get('/twoje-szkolenia',[CourseController::class,'create' ])->name('course.create');

    Route::get('/wybierz-kategorie', [CategoryController::class, 'specialistCategoriesForm'])->name('category.attach');
    Route::post('/specialist/{specialist}/categories', [CategoryController::class, 'attachCategoriesToSpecialist'])->name('specialist.categories.store');
    Route::put('/specialist/{specialist}/categories', [CategoryController::class, 'updateSpecialistCategories'])->name('specialist.categories.update');

    Route::get('/wybierz-miejsce-uslugi', [ServiceController::class, 'index'])->name('service.form');
    Route::post('/specialist/{specialist}/services', [ServiceController::class, 'store'])->name('store.services');

    Route::get("/dla-specjalisty/moja/tablica", SpecialistDashboardController::class)->name('specialist.dashboard');

    

    Route::get('dla-specjalisty/specjalista/jezyki',[LanguageController::class, 'create'])->name('language.create');
});

Route::middleware(["auth", "spec"])->prefix('dla-specjalisty')->group(function () {
    Route::put('/specialist/{specialist}', [SpecialistController::class, 'update'])->name('specialist.profile.update');
    Route::put('/specialist/{specialist}/address/{address}', [AddressController::class, 'updateForSpecialist'])->name('specialist.address.update');
    Route::get('/specjalista/{specialist}/profil', [SpecialistController::class, 'edit'])->name('specialist.profile.edit');
    Route::post('/specialist/{specialist}/address/new', [AddressController::class, 'storeForSpecialistAndRedirectBack'])->name('specialist.address.store.new');

    Route::delete('/specialist/serviceCity/{serviceCity}',[ServiceCityController::class,'destroy'])->name('specialist.serviceCity.delete');
    Route::put('/specialist/{specialist}/services', [ServiceController::class, 'update'])->name('update.services');

    Route::post('/specialist/{specialist}/price',[PriceController::class, 'store'])->name('specialist.price.store');
    Route::delete('/specialist/{specialist}/price/{price}',[PriceController::class, 'destroy'])->name('specialist.price.delete');
    Route::put('/specialist/{specialist}/price/{price}',[PriceController::class, 'update'])->name('specialist.price.update');

    Route::get('/podaj-ceny',[PriceController::class,'create'])->name('price.create');
    Route::get('/utworz-opis',[DescriptionController::class,'create'])->name('description.create');
    Route::get('/podaj-social-media',[SocialMediaController::class,'create'])->name('socialMedia.create');
    Route::get('/twoje-zdjecia',[IconController::class,'create'])->name('images.create');
    Route::get('/created',[SpecialistController::class,'displaySpecialistCreatedMessage'])->name('specialist.created.message');
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

Route::middleware(["auth", "spec"])->group(function () {
    Route::patch('/notification/{notificationId}',[NotificationController::class, 'specialistNotificationMarkAsRead'])->name('specialist.notification.mark');
    
});

Route::middleware(["auth", "spec"])->group(function () {
    Route::post('/language',[LanguageController::class, 'store'])->name('language.store');
    Route::put('/language/{language}',[LanguageController::class, 'update'])->name('language.update');
    Route::delete('/language/{language}',[LanguageController::class, 'destroy'])->name('language.destroy');    
});

Route::middleware(["auth", "spec"])->group(function () {
    Route::post('/specialist/documents',[DocumentController::class, 'store'])->name('document.store');
    Route::delete('/specialist/document/{document}',[DocumentController::class,'destroy'])->name('document.destroy');
    Route::get('/specialist/document/{document}',[DocumentController::class,'download'])->name('document.download');
    
});

Route::middleware(["auth", "spec"])->group(function () {
    Route::post('/price/{price}',[FavouritePriceController::class, 'associate'])->name('favourite.price.associate');
    
    
});

Route::middleware(["auth", "spec"])->prefix('dla-specjalisty')->group(function () {
    Route::get('/platnosci',[PaymentController::class,'create'])->name('payment.create');
    Route::get('offer/{offer}/transaction/{code?}',[PaymentController::class,'buy'])->name('payment.buy');

    Route::get('/oferty',[ShowOffersController::class,'index'])->name('offers.index');
    Route::get('/oferta/{offer}',[ShowOffersController::class,'show'])->name('offer.show');
    
    Route::get('/platnosci/sukces',[PaymentController::class,'success'])->name('payment.success');
    Route::get('/platnosci/niepowodzenie',[PaymentController::class,'fail'])->name('payment.fail');
});
Route::middleware(["auth", "spec"])->prefix('dla-specjalisty')->group(function () {
    Route::post('social-media',[SocialMediaController::class,'store'])->name('socialMedia.store');
    Route::put('social-media/{socialMedia}',[SocialMediaController::class,'update'])->name('socialMedia.update');
    Route::delete('social-media/{socialMedia}',[SocialMediaController::class,'destroy'])->name('socialMedia.destroy');
});
Route::middleware(["auth", "spec"])->prefix('dla-specjalisty')->group(function () {
    Route::put('payments-methods',SpecialistPaymentMethodsController::class)->name('specialist.payments');
    
});
