<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreServiceRequest;
use App\Models\Province;
use App\Models\ServiceCity;
use App\Models\ServiceKind;
use App\Models\Specialist;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class ServiceController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Specialist/SpecialistServices', ['provinces' => Province::all()]);
    }
    public function store(StoreServiceRequest $request, Specialist $specialist): RedirectResponse
    {
        $user = $request->user();
        $onCond = (isset($request->online[0]) && $request->online[0] === true);
        $statCond = isset($request->stationary[0]) && $request->stationary[0] === true;
        $mobCond = (isset($request->serviceCities) && count($request->serviceCities) > 0);

        if ($user->can('update', $specialist) && ($onCond || $mobCond || $statCond)) {
            if ($onCond) {
                $online = ServiceKind::where('name', 'online')->firstOrFail();
                $specialist->serviceKinds()->attach($online);
            }
            if ($statCond) {
                $stationary = ServiceKind::where('name', 'stationary')->firstOrFail();
                $specialist->serviceKinds()->attach($stationary);
            }
            if ($mobCond) {
                $mobile = ServiceKind::where('name', 'mobile')->firstOrFail();
                $specialist->serviceKinds()->attach($mobile);

                foreach ($request->serviceCities as $city) {
                    $specialist->serviceCities()->firstOrCreate(['name' => strtolower(trim($city['name'])), 'province_id' => (int) $city['province_id']]);
                 
                }
            }

            return to_route('category.attach')->with('message', ['text' => 'Udało się dodać formy świadczenia usług.', 'status' => 'success']);
        } else {
            return redirect()->back()->with('message', ['text' => 'Coś poszło nie tak.', 'status' => 'error']);
        }
    }
    public function update(StoreServiceRequest $request, Specialist $specialist): RedirectResponse
    {
        $user = $request->user();

        $specialist->serviceKinds()->detach();

        $onCond = (isset($request->online[0]) && $request->online[0] === true);
        $statCond = isset($request->stationary[0]) && $request->stationary[0] === true;
        $mobCond = (isset($request->serviceCities) && count($request->serviceCities) > 0);

        if ($user->can('update', $specialist) && ($onCond || $mobCond || $statCond)) {
            if ($onCond) {
                $online = ServiceKind::where('name', 'online')->firstOrFail();
                $specialist->serviceKinds()->attach($online);
            }
            if ($statCond) {
                $stationary = ServiceKind::where('name', 'stationary')->firstOrFail();
                $specialist->serviceKinds()->attach($stationary);
            }
            if ($mobCond) {
                $mobile = ServiceKind::where('name', 'mobile')->firstOrFail();
                $specialist->serviceKinds()->attach($mobile);

                foreach ($request->serviceCities as $city) {
                   $specialist->serviceCities()->firstOrCreate(['name' => strtolower(trim($city['name'])), 'province_id' => (int) $city['province_id']]);
                 
                }
            }

            return to_route('specialist.profile.edit',$specialist->id)->with('message', ['text' => 'Udało się dodać formy świadczenia usług.', 'status' => 'success']);
        } else {
            return redirect()->back()->with('message', ['text' => 'Coś poszło nie tak.', 'status' => 'error']);
        }
    }
}
