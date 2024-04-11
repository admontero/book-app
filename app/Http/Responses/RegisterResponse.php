<?php

namespace App\Http\Responses;

use App\Enums\RoleEnum;
use Illuminate\Support\Facades\Auth;
use Laravel\Fortify\Contracts\RegisterResponse as RegisterResponseContract;

class RegisterResponse implements RegisterResponseContract
{

    public function toResponse($request)
    {
        if ($request->wantsJson()) response()->json(['two_factor' => false]);

        if (Auth::user()->hasAnyRole([RoleEnum::ADMIN->value, RoleEnum::SECRETARIO->value]) && ! redirect()->intended()->getRequest()->routeIs('back.*')) {
            return redirect()->route('back.dashboard');
        }

        if (Auth::user()->hasRole(RoleEnum::LECTOR->value) && redirect()->intended()->getRequest()->routeIs('back.*')) {
            return redirect()->route('front.dashboard');
        }

        return redirect()->intended();
    }

}
