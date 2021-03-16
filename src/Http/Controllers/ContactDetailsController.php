<?php

declare(strict_types=1);

namespace Tipoff\StaffBookings\Http\Controllers;

use Illuminate\Http\Client\Request;
use Tipoff\Locations\Models\Location;
use Tipoff\Support\Http\Controllers\BaseController;

class ContactDetailsController extends BaseController
{
    public function store(Location $location, Request $request)
    {
        /**
         * TODO - User Creation
        $user = CreateBookingUser::updateOrCreateUser($request->validated())->addUserLocation($location)->user();
         */
        $user = null;

        // TODO - import UserTransformer
        return fractal($user) // , new UserTransformer)
            ->respond();
    }
}
