<?php

namespace App\Http\Responses;

use App\Enums\RoleEnum;
use Illuminate\Support\Facades\Auth;
use Laravel\Fortify\Contracts\LoginResponse as LoginResponseContract;

class LoginResponse implements LoginResponseContract
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
