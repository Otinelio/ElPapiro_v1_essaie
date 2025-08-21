<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminAccessController extends Controller
{
    //
    public function showAccessForm()
    {
        // Si l'accès est déjà accordé, rediriger vers l'URL demandée
        if (session()->has('admin_access_granted')) {
            $intendedUrl = session('intended_url', route('login'));
            session()->forget('intended_url');
            return redirect($intendedUrl);
        }

        return view('admin.access-form');
    }

    public function verifyAccess(Request $request)
    {
        $request->validate([
            'admin_password' => 'required|string'
        ]);

        // Mot de passe admin (à configurer dans .env)
        $adminPassword = env('ADMIN_ACCESS_PASSWORD', 'Othnelio@0812');

        if ($request->admin_password === $adminPassword) {
            // Accès accordé - stocker en session
            session(['admin_access_granted' => true]);

            return redirect()->intended(route('login'))
                ->with('success', 'Accès administrateur accordé. Vous pouvez maintenant vous connecter.');
        }

        return back()->withErrors([
            'admin_password' => 'Mot de passe administrateur incorrect.'
        ])->withInput();
    }
}
