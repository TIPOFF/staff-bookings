<?php

namespace Tipoff\StaffBookings\Http\Controllers;

use Tipoff\StaffBookings\Http\Controllers\Controller;
use App\Http\Requests\Booking\StoreCartItem;
use App\Models\CartItem;
use App\Models\User;
use Facades\App\UseCases\AddSlotToCart;

class CartItemsController extends Controller
{
    public function store(User $user, StoreCartItem $request)
    {
        AddSlotToCart::setUser($user)
            ->add($request->validated());

        return response()->json(null, 201);
    }

    public function destroy(CartItem $cartItem)
    {
        $cartItem->delete();

        return response()->json(null, 204);
    }
}
