<?php

declare(strict_types=1);

namespace Tipoff\StaffBookings\Http\Controllers;

use Tipoff\Checkout\Enums\AddressTypes;
use Tipoff\Checkout\Models\Cart;
use Tipoff\Locations\Models\Location;
use Tipoff\StaffBookings\Http\Requests\MakePurchase;
use Tipoff\Support\Http\Controllers\BaseController;

class CheckoutController extends BaseController
{
    public function store(Location $location, MakePurchase $request)
    {
        /** @var Cart $cart */
        $cart = Cart::activeCart($request->user_id);

        $address = $cart->setAddressByType(
            AddressTypes::BILLING,
            Cart::createDomesticAddress($request->address, null, $request->city, $request->zip)
        );
        $address->phone = $request->phone_number;
        $address->save();

        $cart->purchase($request->payment_method_id);

        return response()->json(null, 200);
    }
}
