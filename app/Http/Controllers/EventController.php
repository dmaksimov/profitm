<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Doctrine\DBAL\Events;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function index(Request $request)
    {
        return view('events.index', []);
    }

    public function fetch()
    {
        $events = Event::select('title','start_time as start','end_time as end')->get();
        return $events->toJson();

    }
}
