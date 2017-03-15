<?php

namespace App\Http\Controllers;

use App\Calendar;
use Auth;
use Illuminate\Http\Request;

class CalendarController extends Controller
{
    public function index()
    {
        $events = Calendar::orderBy('start', 'asc')->get();

        return view('calendar.calendar', compact('events'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
                'title'       => 'required',
                'description' => 'required',
                'day'         => 'required',
        ]);

        $str = $request->day;
        $pat = '/(?:Sun|Mon|Tue|Wed|Thu|Fri|Sat) (?:Jan|Feb|Mar|Apr|May|Jun|Jul|Aug|Sep|Oct|Nov|Dec) (?:0?[1-9]|[1-2][0-9]|3[0-1]) [0-9]{4} [0-9]{2}:[0-9]{2}:[0-9]{2} GMT\\+[0-9]{4}/';
        $date = preg_match($pat, $str, $mat) ? date('Y-m-d', strtotime($mat[0])) : '';

        Calendar::create([
            'title'       => $request->title,
            'description' => $request->description,
            'start'       => $date,
            'color'       => '#7a7a7a',
        ]);

        notify()->flash('Event created!', 'success');

        return redirect()->to('calendar');
    }

    public function destroy($id)
    {
        if (Auth::user()->privilege !== 'Student') {
            Calendar::destroy($id);

            notify()->flash('Event deleted!', 'success');

            return redirect()->to('/calendar');
        }
    }

    public function events()
    {
        $events = Calendar::all();

        return $events;
    }

    public function viewEvent(Calendar $calendar)
    {
        return view('calendar.view-event', compact('calendar'));
    }
}
