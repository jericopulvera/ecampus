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

        // GET THE FOLLOWING USERS
        // $following[] = auth()->id();
        // foreach (auth()->user()->following as $user) {
        //     $following[] = $user->id;
        // }

        // // GET THE RANKED POSTS FIRST
        // $posts = Post::whereIn('user_id', $following)
        // ->where('time', '!=', 0)
        // ->orderBy('time', 'desc')
        // ->get();

        // foreach($posts as $post) {
        //     // get the interaction value
        //     $interaction = Interaction::where('user_id', auth()->id())
        //     ->where('target_id', $post->userId())
        //     ->first();

        //     // calculate the edge
        //     if ($interaction !== null) {
        //         $post->edge = $post->weight * $interaction->affinity * $post->time;
        //     } else {
        //         $post->edge = $post->weight * 1 * $post->time;
        //     }
        // }

        // // Sort the posts descending basead on the calculated value
        // $ranked = $posts->sortByDesc(function($post) {
        //     return sprintf('%-12s%s', $post->edge, $post->created_at);
        // });

        // // Make a paginator for all the posts
        // if (request()->query() == null) {
        //     $page = 1;
        // } else {
        //     $page = request()->query()['page'];
        // }

        // $perPage = 10;
        // $rankedPosts = new LengthAwarePaginator(
        //     $ranked->forPage($page, $perPage)->values(),
        //     count($ranked),
        //     $perPage,
        //     $page,
        //     ['path' => request()->url(), 'query' => request()->query()]
        // );

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
            $weight = 100;
        } else {
            $weight = 1;
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
        //
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
