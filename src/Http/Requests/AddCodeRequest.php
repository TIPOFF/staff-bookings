<?php

declare(strict_types=1);

namespace Tipoff\StaffBookings\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Tipoff\Checkout\Models\Cart;
use Tipoff\Checkout\Rules\AdjustmentCode;

class AddCodeRequest extends FormRequest
{
    protected $cart;

    public function authorize()
    {
        $this->cart = Cart::activeCart($this->user->id);

        return $this->cart->cartItems->count() > 0;
    }

    public function rules()
    {
        return [
            'code' => ['required', 'string', new AdjustmentCode()]
        ];
    }
}
