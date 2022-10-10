<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Prediction;
use App\Traits\LogsTrait;
// use Spatie\Activitylog\Traits\LogsActivity;

class HomeController extends Controller
{
    use LogsTrait;

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $this->generateLog('login');

        $prediction = Prediction::find(auth()->user()->id);
        $response = ['init' => false, 'prediction' => $prediction];
        return view('home-auth',compact('response'));
    }

    public function homeGuest() {
        return view('home-guest');
    }

    public function myLogout(Request $request) {

        $this->generateLog('logout');

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return view('home-guest');
    }

    public function myLogin(Request $request) {

        $this->generateLog('logout');

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return view('home-guest');
    }


}