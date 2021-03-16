<?php

declare(strict_types=1);

namespace Tipoff\StaffBookings\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Tipoff\Checkout\Models\Cart;
use Tipoff\Checkout\Rules\AdjustmentCode;

class AddCodeRequest extends FormRequest
{
    public function authorize()
    {
        return Cart::activeCart($this->user->id)->getItems()->count() > 0;
    }

    public function rules()
    {
        return [
            'code' => ['required', 'string', new AdjustmentCode()],
        ];
    }
}
