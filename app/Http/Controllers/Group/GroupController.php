<?php

namespace App\Http\Controllers\Group;

use App\Http\Requests\StoreGroupRequest;
use App\Http\Controllers\Controller;
use App\Group;
use Auth;
use Illuminate\Http\Request;

class GroupController extends Controller
{
    public function index()
    {
        return view('group.group');
    }

    public function create()
    {
        return view('group.group-create');
    }

    public function store(StoreGroupRequest $request)
    {
        if (Group::where('slug', $request->slug)->first() != null) {
            notify()->flash('Class already exist', 'error');
            return redirect()->to('groups/create');
        }

        if (Auth::user()->privilege != 'Student') {
            $group = Group::create([
                'term_id'   => $request->term,
                'professor' => strtoupper(Auth::user()->name),
                'subject'   => strtoupper($request->subject),
                'section'   => strtoupper($request->section),
                'room'      => strtoupper($request->room),
                'dow'       => serialize($request->schedule),
                'slug'      => $request->slug,
                'start'     => $request->start,
                'end'       => $request->end,
            ]);
            Auth::user()->groups()->attach($group, ['role' => 'admin', 'status' => 1]);

            return redirect()->to('groups/'.$group->slug);
        }
    }

    public function getLists()
    {
        $groups = Group::all();

        return view('group.group-list', compact('groups'));
    }

    public function myGroups()
    {
        $groups = Auth::user()->groups()->paginate(10);

        return view('group.group-mygroups', compact('groups'));
    }

    public function group(Group $group)
    {
        if ($group->inGroup() == true) {
            $pending = $group->pending();
            $admin = $group->professorId();

            return view('group.group-index', compact('group', 'pending', 'admin'));
        }

        notify()->flash('Oops.', 'info', [
            'timer' => 3000,
            'text'  => 'You\'re not yet part of this class.',
        ]);

        return redirect()->to('/groups/list');
    }
}
