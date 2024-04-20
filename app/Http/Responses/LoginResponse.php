<?php

namespace App\Http\Responses;

use App\Enums\RoleEnum;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Laravel\Fortify\Contracts\LoginResponse as LoginResponseContract;

class LoginResponse implements LoginResponseContract
{

    public function toResponse($request)
    {
        if ($request->wantsJson()) response()->json(['two_factor' => false]);

        $targetUrl = redirect()->intended()->getTargetUrl();

        $routeName = get_route_name_by_url($targetUrl);

        if (Auth::user()->hasAnyRole([RoleEnum::ADMIN->value, RoleEnum::SECRETARIO->value]) && ! Str::startsWith($routeName, 'back.')) {
            return redirect()->route('back.dashboard');
        }

        if (Auth::user()->hasRole(RoleEnum::LECTOR->value) && Str::startsWith($routeName, 'back.')) {
            return redirect()->route('front.dashboard');
        }

        return redirect()->to($targetUrl);
    }

}
