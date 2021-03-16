<?php

declare(strict_types=1);

namespace Tipoff\StaffBookings\Http\Controllers;

use Tipoff\Authorization\Models\User;
use Tipoff\Checkout\Models\Cart;
use Tipoff\Checkout\Transformers\CartTransformer;
use Tipoff\StaffBookings\Http\Requests\AddCodeRequest;
use Tipoff\Support\Http\Controllers\BaseController;

class CartsController extends BaseController
{
    public function show(User $user)
    {
        $cart = Cart::activeCart($user->id);

        return fractal($cart, new CartTransformer)
            ->includeItems()
            ->respond();
    }

    public function addCode(User $user, AddCodeRequest $request)
    {
        $cart = Cart::activeCart($user->id)->applyCode($request->code);

        return fractal($cart, new CartTransformer)
            ->includeItems()
            ->respond();
    }
}
