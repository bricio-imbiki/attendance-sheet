<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Event;
use Illuminate\Contracts\View\View;

class HomeController extends Controller
{
    public function index() : View
    {
        $events = Event::orderBy('debut', 'asc')->paginate(9);

        $active = 'home';

        $tranche = $this->getTranche();

        return view('home', [
            'events' => $events,
            'active' => $active,
            'tranche' => $tranche
        ]);
    }


    public function about()
    {
        return view('about', [
            'active' => 'about'
        ]);
    }


    public function login()
    {
        return view('login', [
            'active' => 'login'
        ]);
    }


    public function getTranche() : int
    {
        if (intval(now()->format('H')) >= Carbon::getMidDayAt()) return 1;
        return 0;
    }
}
