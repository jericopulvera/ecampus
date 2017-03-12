<?php

namespace App\Http\Controllers\Group;

use App\Events\GroupPostWasCreated;
use App\Events\GroupUserWasKicked;
use App\Events\JoinGroupRequested;
use App\Http\Requests\StoreGroupRequest;
use App\Group;
use App\GroupComment;
use App\GroupGrade;
use App\GroupPost;
use App\Http\Controllers\Controller;
use App\User;
use App\Setting;
use Auth;
use Datatables;
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

    public function dataTable()
    {
        $groups = Group::all();

        $lists = collect();

        foreach($groups as $group) {
            $group->term = $group->term;

            if ($group->inGroup() == true) {
                $group->action = "<a href='".url('groups', $group->slug)."' class='button is-small is-info'>View</a>";
            } elseif ($group->canJoin() == true) {
                $group->action = "<a href='#' onClick='joinRequest($group->id);' id='join-request$group->id' class='button is-small is-primary'>Join Class</a>";
            } else {
                $group->action = "<a href='#' class='button is-small is-warning is-disabled'>Pending</a>";
            }

            $lists->push($group);
        }

        return response()->json([
            'data' => $lists,
        ]);
    }

    public function joinRequest(Request $request)
    {
        $group = Group::find($request->group_id);
        $antiSpam = $group->users()->where('usn', Auth::user()->usn)->count() == 0;
        if ($antiSpam) {
            Auth::user()->groups()->attach($request->group_id, ['role' => Auth::user()->privilege, 'status' => 0]);
            broadcast(new JoinGroupRequested($request->group_id, $request->user()))->toOthers();
        }

        return 1;
    }

    public function pendingRequests(Group $group)
    {
        return $group->pending();
    }

    public function acceptRequest(Group $group, User $user)
    {
        $user->notify(new \App\Notifications\AcceptedInGroup($group));
        $user->groups()->updateExistingPivot($group->id, ['status' => 1]);

        $week = ['prelim', 'midterm', 'finals'];

        for ($i = 0; $i < count($week); $i++) {
            GroupGrade::firstOrCreate([
                'user_id'  => $user->id,
                'group_id' => $group->id,
                'week'     => $week[$i],
            ]);
        }
    }

    public function declineRequest(Group $group, User $user)
    {
        $user->groups()->detach($group->id);
    }

    public function kickMember(Group $group, User $user)
    {
        $user->groups()->detach($group->id);
        $posts = GroupPost::where('user_id', $user->id)->where('group_id', $group->id)->delete();

        foreach (GroupPost::where('group_id', $group->id)->get() as $post) {
            GroupComment::where('user_id', $user->id)->where('group_post_id', $post->id)->delete();
        }

        broadcast(new GroupUserWasKicked($group, $user))->toOthers();
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

    public function leaveClass(Group $group, User $user)
    {
        $check = $group->users->where('id', $user->id)->first()->pivot->role;
        if ($check != 'Student') {
            Group::destroy($group->id);
        } else {
            $user->groups()->detach($group->id);
            $posts = GroupPost::where('user_id', $user->id)->where('group_id', $group->id)->delete();

            foreach (GroupPost::where('group_id', $group->id)->get() as $post) {
                GroupComment::where('user_id', $user->id)->where('group_post_id', $post->id)->delete();
            }
        }
    }

    public function passProfessorRole(Group $group, User $user)
    {
        $group->update(['professor' => $user->name]);
        Auth::user()->groups()->updateExistingPivot($group->id, ['role' => 'professor']);
        $user->groups()->updateExistingPivot($group->id, ['role' => 'admin']);
    }

    public function fetchMembers(Group $group)
    {
        $admin = $group->users()
            ->where('role', 'admin')
            ->first();

        $professors = $group->users()->where('role', '!=', 'admin')
            ->where('role', '!=', 'student')
            ->where('status', 1)
            ->orderBy('name', 'asc')
            ->get();

        $students = $group->users()
            ->where('role', 'student')
            ->where('status', 1)
            ->orderBy('name', 'asc')
            ->get();

        foreach ($students as $student) {
            if ($student->pivot->role == 'Student') {
                $grades = GroupGrade::where('user_id', $student->id)->where('group_id', $student->pivot->group_id)->get();

                $p = $grades->where('week', 'prelim')->first();
                $m = $grades->where('week', 'midterm')->first();
                $f = $grades->where('week', 'finals')->first();
                $prelim = ($p->class_standing * .1) + ((($p->quiz_one + $p->quiz_two) / 2) * .4) + ($p->exam * .5);
                $midterm = ($m->class_standing * .1) + ((($m->quiz_one + $m->quiz_two) / 2) * .4) + ($m->exam * .5);
                $finals = ($f->class_standing * .1) + ((($f->quiz_one + $f->quiz_two) / 2) * .4) + ($f->exam * .5);

                $totalGrade = ($prelim * .3) + ($midterm * .3) + ($finals * .4);
                $student->grades = $grades;
                $student->totalGrade = $totalGrade;
            }
        }

        return compact('admin', 'professors', 'students');
    }

    public function updateSettings(Group $group)
    {
        $this->validate(request(), [
            'room'     => 'required',
            'schedule' => 'required',
        ]);

        $group->update([
            'room'  => request('room'),
            'dow'   => serialize(request('schedule')),
            'start' => request('start'),
            'end'   => request('end'),
        ]);

        return 1;
    }

    public function fetchGroupPosts(Group $group)
    {
        return GroupPost::with('user')->where('group_id', $group->id)->orderBy('created_at', 'dsc')->paginate(15);
    }

    public function createPost(Request $request, Group $group)
    {
        $check = Auth::user()->groups()->where('group_id', $group->id)->where('user_id', Auth::id())->first();
        if ($check != null) {
            $post = GroupPost::create([
                'group_id' => $group->id,
                'user_id'  => Auth::id(),
                'body'     => $request->body,
            ]);
            broadcast(new GroupPostWasCreated($post, Auth::user()))->toOthers();

            return $post;
        }

        return response(null, 403);
    }
}
