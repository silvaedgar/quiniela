<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Prediction;
use App\Traits\LogsTrait;

class HomeController extends Controller
{
    use LogsTrait;

    public function __construct()
    {
        $this->middleware('auth')->except('homeGuest','images');
    }

    public function images() {
        return ['ahmad-binalin.jpeg','al-bayt.jpg','al-janoub.jpeg','al-rayan.jpg','al-thumama.jpg','khalifa.jpeg','lusail.jpeg','974.jpg'];
    }

    public function index()
    {
        $this->generateLog('login');
        $prediction = Prediction::find(auth()->user()->id);
        $response = ['init' => false, 'prediction' => $prediction];
        return view('home-auth',compact('response'));
    }

    public function homeGuest() {
        $images = $this->images();
        return view('home-guest',compact('images'));
    }

    public function myLogout(Request $request) {

        $this->generateLog('logout');

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        $images = $this->images();
        return view('home-guest',compact('images'));
    }

    public function myLogin(Request $request) {
        return "EDGAR";
    }
}
