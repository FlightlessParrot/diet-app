<?php

namespace App\Http\Middleware;

use App\Models\Province;
use Illuminate\Http\Request;
use Inertia\Middleware;
use Orchid\Platform\Models\Role;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that is loaded on the first page visit.
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determine the current asset version.
     */
    public function version(Request $request): string|null
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {
        $user=$request->user();
        $user?->phone;
        $specialist=$user?->specialist;
        $specialist!== null && $specialist->phone;
        $subscription =$specialist ? $specialist->activeSubscription() : null;
        return [
            ...parent::share($request),
            'auth' => [
                'user' => $user,
                'role' => $user?->myRole,
                'specialist' => $user!==null && $specialist !==null ? $specialist : null,
            ],'flash' => [
                'message' => fn () => $request->session()->get('message')
            ],
            'subscription' =>$subscription
            
        ];
    }
}
