<?php

declare(strict_types=1);

namespace Tipoff\StaffBookings\Http\Controllers;

use Illuminate\Http\Client\Request;
use Tipoff\Authorization\Models\User;
use Tipoff\Checkout\Models\Cart;
use Tipoff\Checkout\Models\CartItem;
use Tipoff\Support\Http\Controllers\BaseController;

class CartItemsController extends BaseController
{
    public function store(User $user, Request $request)
    {
        /**
         * TODO - construct to add cart item
        Cart::activeCart($user->id)->upsertItem(
            Cart::createItem($sellable, $sellable->sku, $sellable->amount, $quantity)
                            ->setLocationId($sellable->location_id)
                            ->setTaxCode($sellable->tax_code);
        );
         */

        return response()->json(null, 201);
    }

    public function destroy(CartItem $cartItem)
    {
        $cartItem->delete();

        return response()->json(null, 204);
    }
}
