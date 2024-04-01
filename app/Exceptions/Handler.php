<?php

namespace App\Exceptions;

use App\Enums\RoleEnum;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    /**
     * Get the view used to render HTTP exceptions.
     *
     * @param  \Symfony\Component\HttpKernel\Exception\HttpExceptionInterface  $e
     * @return string
    */
    protected function getHttpExceptionView(\Symfony\Component\HttpKernel\Exception\HttpExceptionInterface $e)
    {
        $backErrorView = "back.errors.{$e->getStatusCode()}";
        $frontErrorView = "front.errors.{$e->getStatusCode()}";

        if (auth()->user()?->hasAnyRole([RoleEnum::ADMIN->value, RoleEnum::SECRETARIO->value])) {
            if (view()->exists($backErrorView)) {
                return $backErrorView;
            }
        }

        if (auth()->user()?->hasRole(RoleEnum::LECTOR->value)) {
            if (view()->exists($frontErrorView)) {
                return $frontErrorView;
            }
        }

        return "errors::{$e->getStatusCode()}";
    }
}
