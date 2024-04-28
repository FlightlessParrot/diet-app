<?php

use App\Http\Controllers\AddressController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SpecialistController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ServiceController;
use Illuminate\Foundation\Testing\WithoutMiddleware;

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Inertia\Response;

Route::middleware(["auth","spec"])->group(function () {
    Route::post("/specjalist",[SpecialistController::class, 'store'])->WithoutMiddleware('spec')->name('specialist.store');
    Route::get("/utworz-specjaliste",[SpecialistController::class, 'create'])->WithoutMiddleware('spec')->name('specialist.create');
    Route::post('/specialist/{specialist}/address',[AddressController::class, 'storeForSpecialist'])->name('specialist.address.store');
    Route::get('/specjalista/address',[AddressController::class, 'index'])->name('specialist.address.create');
    Route::delete('/specialist/{specialist}',[SpecialistController::class,'destroy'])->name('specialist.remove');

    Route::get('/wybierz-kategorie',[CategoryController::class, 'specialistCategoriesForm'])->name('category.attach');
    Route::post('/specialist//{specialist}/categories',[CategoryController::class,'attachCategoriesToSpecialist'])->name('specialist.categories.store');

    Route::get('/wybierz-miejsce-uslugi',[ServiceController::class,'index'])->name('service.form');
    Route::post('/specialist/{specialist}/services',[ServiceController::class, 'store'])->name('store.services');

    Route::get("/specjalista/tablica",function () : Response
    {
        return Inertia::render('Specialist/SpecialistDashboard');
    })->name('specialist.dashboard');
    Route::get('/profil', [ProfileController::class, 'edit'])->name('specialist.profile.edit');
});