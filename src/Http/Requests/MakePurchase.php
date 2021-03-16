<?php

declare(strict_types=1);

namespace Tipoff\StaffBookings\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MakePurchase extends FormRequest
{
    public function rules()
    {
        return [
            'user_id' => 'required|exists:users,id',
            'payment_method_id' => 'required',
            'address' => 'required|string',
            'city' => 'required|string',
            'state' => 'required|string',
            'zip' => 'required|string',
            'phone_number' => 'required|string',
        ];
    }
}
