<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;

class LoginController extends Controller
{
    /**
     * Menampilkan formulir login.
     *
     * @return \Illuminate\View\View
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Menangani permintaan login.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    //     public function login(Request $request)
    // {
    //     $request->validate([
    //         'username' => 'required',
    //         'password' => 'required',
    //     ]);

    //     $credentials = $request->only('username', 'password');

    //     $user = User::where('username', $credentials['username'])->first();

    //     // dd($user);

    //     if (Auth::attempt($credentials)) {
    //         $user = Auth::user();
    //         // Gabungkan informasi dari tabel lain berdasarkan IDNIK
    //         $userWithJoin = User::join('user', 'login.idnik', '=', 'user.idnik')
    //             ->where('user.idnik', $user->idnik)
    //             ->select('user.*', 'login.*')
    //             ->first();


    //         // Simpan informasi pengguna beserta informasi dari tabel lain dalam session
    //         $request->session()->put('user', $userWithJoin);
    //         // dd($request->session()->put('user', $userWithJoin));
    //         // Jika autentikasi berhasil, redirect ke halaman yang diinginkan
    //         return redirect()->intended('/');
    //     } else {
    //         // Jika autentikasi gagal, redirect kembali ke halaman login
    //         return redirect()->route('loginForm')->with('error', 'Username atau password salah.');
    //     }
    // }
    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        $credentials = $request->only('username', 'password');

        $user = User::where('username', $credentials['username'])
            ->where('password', $credentials['password'])
            ->first();


        if ($user) {
            Auth::login($user);

            $userWithJoin = User::join('user', 'user.idnik', '=', 'login.idnik')
    ->leftJoin('access_menu', 'access_menu.idnik', '=', 'user.idnik')
    ->where('user.idnik', $user->idnik)
    ->select('user.*', 'login.*', 'access_menu.access_type')
    ->first();

            // dd($userWithJoin);
            $request->session()->put('user', $userWithJoin);
              // Check if there is a URL that the user tried to access before login
        if ($request->session()->has('url.intended')) {
            // Get the intended URL
            $intendedUrl = $request->session()->get('url.intended');
            // Forget the intended URL so that it won't be used in the next redirect
            $request->session()->forget('url.intended');
            // Redirect to the intended URL
            return Redirect::to($intendedUrl);
        }

        // If there is no intended URL, redirect to a default route, e.g., the home page
        return redirect('/');
        } else {
            return redirect()->route('loginForm')->with('error', 'Username atau password salah.');
        }
    }

    /**
     * Menangani proses logout.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->forget('user');

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return view('auth-logout-basic');
    }
}
