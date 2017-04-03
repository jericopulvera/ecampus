<?php

namespace App\Http\Controllers\Feed;

use App\Calendar;
use App\Edgerank\Feed;
use App\Http\Controllers\Controller;
use App\Interaction;
use App\Post;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class PostController extends Controller
{
    public function page()
    {
        $events = Calendar::orderBy('start', 'ASC')->where('start', '>=', Carbon::now())->limit(7)->get();
        $current_event = Calendar::where('start', Carbon::now()->format('Y-m-d'))->get();

        return view('home-page', compact('events', 'current_event'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $feed = new Feed();
        $ranked = collect($feed->getRankedPosts());

        if (request()->query() == null) {
            $page = 1;
        } else {
            $page = request()->query()['page'];
        }

        $perPage = 10;
        $rankedPosts = new LengthAwarePaginator(
            $ranked->forPage($page, $perPage)->values(),
            count($ranked),
            $perPage,
            $page,
            ['path' => request()->url(), 'query' => request()->query()]
        );

        return $rankedPosts;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
        $check = auth()->user()->privilege;

        if ($check == 'Dean') {
            $weight = 1000 * 150;
        } else {
            $weight = 1;
        }

        foreach(auth()->user()->posts as $post) {
            $post->decrement('time');
        }

        $post = auth()->user()->posts()->create([
            'body'   => request('body'),
            'weight' => $weight,
        ]);

        return $post;
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post = Post::find($id);
        if ($post === null) {
            notify()->flash('Oops!', 'error', [
                 'timer' => 3000,
                 'text' => 'The post no longer exist',
             ]);
            return redirect()->back();
        }
        $classes = auth()->user()->userGroups;
        return view('post.show-post', compact('post', 'classes'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int                      $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Post $post)
    {
        $post->update([
            'body'  => request('body'),
            'weight' => request('weight')
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        $post->delete();
    }

    public function getUserFeed($id)
    {
        $posts = Post::where('user_id', $id)->orderBy('created_at', 'desc')->paginate(15);

        return $posts;
    }

    public function myFeed()
    {
        return Auth::user()->posts()->orderBy('created_at', 'desc')->paginate(15);
    }
}
