<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreStandingsRequest extends FormRequest
{
    public function authorize()
    {
        // Only admins can store standings
        return Auth::check() && Auth::user()->role === 'admin';
    }

    public function rules()
    {
        return [
            'session_type' => 'required|in:race,sprint',
            'race_id' => 'required|exists:races,id',
            'session_id' => 'nullable|exists:sprint_races,id|required_if:session_type,sprint',
            'results' => 'required|array',
            'results.*.driver_id' => 'required|exists:drivers,id',
            'results.*.placement' => 'required|integer|min:1|max:20',
        ];
    }
}
