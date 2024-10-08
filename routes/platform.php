<?php

declare(strict_types=1);

use App\Models\Specialist;
use App\Orchid\Screens\Category\CategoryListScreen;
use App\Orchid\Screens\Category\NewCategoryScreen;
use App\Orchid\Screens\Category\UpdateCategoryScreen;
use App\Orchid\Screens\Discount\CreateDiscountScreen;
use App\Orchid\Screens\Discount\DiscountListScreen;
use App\Orchid\Screens\Discount\DiscountScreen;
use App\Orchid\Screens\Offer\EditOfferScreen;
use App\Orchid\Screens\Specialist\EditSpecialistScreen;
use App\Orchid\Screens\Examples\ExampleActionsScreen;
use App\Orchid\Screens\Examples\ExampleCardsScreen;
use App\Orchid\Screens\Examples\ExampleChartsScreen;
use App\Orchid\Screens\Examples\ExampleFieldsAdvancedScreen;
use App\Orchid\Screens\Examples\ExampleFieldsScreen;
use App\Orchid\Screens\Examples\ExampleGridScreen;
use App\Orchid\Screens\Examples\ExampleLayoutsScreen;
use App\Orchid\Screens\Examples\ExampleScreen;
use App\Orchid\Screens\Examples\ExampleTextEditorsScreen;
use App\Orchid\Screens\Newsletter\NewsletterListScreen;
use App\Orchid\Screens\Offer\NewOfferScreen;
use App\Orchid\Screens\Offer\OfferListScreen;
use App\Orchid\Screens\PlatformScreen;
use App\Orchid\Screens\Role\RoleEditScreen;
use App\Orchid\Screens\Role\RoleListScreen;
use App\Orchid\Screens\Specialist\SpecialistListScreen;
use App\Orchid\Screens\Subscription\SubscriptionListScreen;
use App\Orchid\Screens\User\UserEditScreen;
use App\Orchid\Screens\User\UserListScreen;
use App\Orchid\Screens\User\UserProfileScreen;
use Illuminate\Support\Facades\Route;
use Tabuna\Breadcrumbs\Trail;
/*
|--------------------------------------------------------------------------
| Dashboard Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the need "dashboard" middleware group. Now create something great!
|
*/

// Main
Route::screen('/main', PlatformScreen::class)
    ->name('platform.main');

// Platform > Profile
Route::screen('profile', UserProfileScreen::class)
    ->name('platform.profile')
    ->breadcrumbs(fn (Trail $trail) => $trail
        ->parent('platform.index')
        ->push(__('Profile'), route('platform.profile')));


// Platform > System > Users > User
Route::screen('users/{user}/edit', UserEditScreen::class)
    ->name('platform.systems.users.edit')
    ->breadcrumbs(fn (Trail $trail, $user) => $trail
        ->parent('platform.systems.users')
        ->push($user->name, route('platform.systems.users.edit', $user)));

// Platform > System > Users > Create
Route::screen('users/create', UserEditScreen::class)
    ->name('platform.systems.users.create')
    ->breadcrumbs(fn (Trail $trail) => $trail
        ->parent('platform.systems.users')
        ->push(__('Create'), route('platform.systems.users.create')));

// Platform > System > Users
Route::screen('users', UserListScreen::class)
    ->name('platform.systems.users')
    ->breadcrumbs(fn (Trail $trail) => $trail
        ->parent('platform.index')
        ->push(__('Users'), route('platform.systems.users')));

// Platform > System > Roles > Role
Route::screen('roles/{role}/edit', RoleEditScreen::class)
    ->name('platform.systems.roles.edit')
    ->breadcrumbs(fn (Trail $trail, $role) => $trail
        ->parent('platform.systems.roles')
        ->push($role->name, route('platform.systems.roles.edit', $role)));

// Platform > System > Roles > Create
Route::screen('roles/create', RoleEditScreen::class)
    ->name('platform.systems.roles.create')
    ->breadcrumbs(fn (Trail $trail) => $trail
        ->parent('platform.systems.roles')
        ->push(__('Create'), route('platform.systems.roles.create')));

// Platform > System > Roles
Route::screen('roles', RoleListScreen::class)
    ->name('platform.systems.roles')
    ->breadcrumbs(fn (Trail $trail) => $trail
        ->parent('platform.index')
        ->push(__('Roles'), route('platform.systems.roles')));

// Example...
Route::screen('example', ExampleScreen::class)
    ->name('platform.example')
    ->breadcrumbs(fn (Trail $trail) => $trail
        ->parent('platform.index')
        ->push('Example Screen'));

Route::screen('specialisci', SpecialistListScreen::class)
    ->name('platform.specialists')
    ->breadcrumbs(fn (Trail $trail) => $trail
            ->parent('platform.index')
            ->push('specjaliści'));

            Route::screen('specjalisci/specialista/{specialist}', EditSpecialistScreen::class)
            ->name('platform.specialist.edit')
            ->breadcrumbs(fn (Trail $trail, Specialist $specialist) => $trail
                    ->parent('platform.specialists')
                    ->push('Specjalista'.$specialist->name, route('platform.specialist.edit', $specialist)));
Route::screen('oferty', OfferListScreen::class)
    ->name('platform.offers')
    ->breadcrumbs(fn (Trail $trail) => $trail
            ->parent('platform.index')
            ->push('oferty'));
            Route::screen('oferty/oferta/{offer}',EditOfferScreen::class)
            ->name('platform.offer.edit')
            ->breadcrumbs(fn (Trail $trail) => $trail
            ->parent('platform.offers')
            ->push('oferta'));
            Route::screen('oferty/nowa/oferta',NewOfferScreen::class)
            ->name('platform.offer.new')
            ->breadcrumbs(fn (Trail $trail) => $trail
            ->parent('platform.offers')
            ->push('oferta'));

Route::screen('subskrypcje', SubscriptionListScreen::class)
    ->name('platform.subscriptions')
    ->breadcrumbs(fn (Trail $trail) => $trail
        ->parent('platform.index')
        ->push('subskrypcje'));

Route::screen('newsletter', NewsletterListScreen::class)
    ->name('platform.newsletter')
    ->breadcrumbs(fn (Trail $trail) => $trail
        ->parent('platform.index')
        ->push('newsletter'));

Route::screen('kupony', DiscountListScreen::class)
    ->name('platform.discounts')
    ->breadcrumbs(fn (Trail $trail) => $trail
        ->parent('platform.index')
        ->push('kupony'));
        Route::screen('kupony/kupon/{discount}',DiscountScreen::class)
        ->name('platform.discount')
        ->breadcrumbs(fn (Trail $trail) => $trail
        ->parent('platform.discounts')
        ->push('kupon'));
        Route::screen('kupony/utworz',CreateDiscountScreen::class)
        ->name('platform.discount.store')
        ->breadcrumbs(fn (Trail $trail) => $trail
        ->parent('platform.discounts')
        ->push('utworz-kupon'));

Route::screen('kategorie', CategoryListScreen::class)
    ->name('platform.categories')
    ->breadcrumbs(fn (Trail $trail) => $trail
            ->parent('platform.index')
            ->push('kategorie'));
            Route::screen('kategoria/{category}', UpdateCategoryScreen::class)
                ->name('platform.category.edit')
                ->breadcrumbs(fn (Trail $trail) => $trail
                    ->parent('platform.categories')
                    ->push('kategoria'));
                    Route::screen('utworz/kategoria', NewCategoryScreen::class)
                    ->name('platform.category.new')
                    ->breadcrumbs(fn (Trail $trail) => $trail
                        ->parent('platform.categories')
                        ->push('nowa-kategoria'));
// Route::screen('/examples/form/fields', ExampleFieldsScreen::class)->name('platform.example.fields');
// Route::screen('/examples/form/advanced', ExampleFieldsAdvancedScreen::class)->name('platform.example.advanced');
// Route::screen('/examples/form/editors', ExampleTextEditorsScreen::class)->name('platform.example.editors');
// Route::screen('/examples/form/actions', ExampleActionsScreen::class)->name('platform.example.actions');

// Route::screen('/examples/layouts', ExampleLayoutsScreen::class)->name('platform.example.layouts');
// Route::screen('/examples/grid', ExampleGridScreen::class)->name('platform.example.grid');
// Route::screen('/examples/charts', ExampleChartsScreen::class)->name('platform.example.charts');
// Route::screen('/examples/cards', ExampleCardsScreen::class)->name('platform.example.cards');

//Route::screen('idea', Idea::class, 'platform.screens.idea');
