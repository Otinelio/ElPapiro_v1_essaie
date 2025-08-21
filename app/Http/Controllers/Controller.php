<?php

namespace App\Http\Controllers;

use App\Models\Panier;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

abstract class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    protected function getOrCreateSessionId()
    {
        if (!session()->has('session_id')) {
            session(['session_id' => uniqid('cart_', true)]);
        }
        return session('session_id');
    }

    protected function getCartTotal()
    {
        if (Auth::check()) {
            return Panier::where('user_id', Auth::id())->sum('quantite');
        } else {
            $sessionId = $this->getOrCreateSessionId();
            return Panier::where('session_id', $sessionId)->sum('quantite');
        }
    }
}