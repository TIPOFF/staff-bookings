<?php

namespace Tipoff\StaffBookings\Http\Controllers;

use Tipoff\StaffBookings\Http\Controllers\Controller;
use App\Models\Discount;
use App\Models\User;
use App\Transformers\CartTransformer;
use Tipoff\StaffBookings\Http\Requests\StoreDiscountApplication;

class DiscountApplicationsController extends Controller
{
    public function store(User $user, StoreDiscountApplication $request)
    {
        $discount = Discount::where('code', $request->code)->first();

        $user->cart()->applyVoucher($discount);

        return fractal($user->cart(), new CartTransformer)
            ->respond();
    }
}
