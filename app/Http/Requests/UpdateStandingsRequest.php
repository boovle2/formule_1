<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdateStandingsRequest extends FormRequest
{
    public function authorize()
    {
        return Auth::check() && Auth::user()->role === 'admin';
    }

    public function rules()
    {
        return [
            'results' => 'required|array',
            'results.*.driver_id' => 'required|exists:drivers,id',
            'results.*.placement' => 'required|integer|min:1|max:20',
        ];
    }
}
