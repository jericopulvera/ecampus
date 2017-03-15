<?php

namespace App\Edgerank;

class Feed
{
    // CONNECT TO DATABASE
    private static function connect()
    {
        try {
            $server = env('DB_HOST');
            $username = env('DB_USERNAME');
            $password = env('DB_PASSWORD');
            $db = env('DB_DATABASE');

            return $db = mysqli_connect($server, $username, $password, $db);
        } catch (Exception $ex) {
            echo 'ERROR'.$ex->getMessage();
        }
    }

    // SORT THE POSTS BASED ON EDGES
    public function getRankedPosts()
    {
        $posts = $this->getCalculatedPosts();
        $length = count($posts);

        // Bubble sort Highest edge to lowest
        for ($i = 0; $i < $length; $i++) {
            for ($j = 0; $j < $length; $j++) {
                if ($posts[$i]['edge'] > $posts[$j]['edge']) {
                    $temp = $posts[$i];
                    $posts[$i] = $posts[$j];
                    $posts[$j] = $temp;
                }
            }
        }

        return $posts;
    }

    // LOOP THROUGH THE POSTS AND CALCULATE THE EDGES
    private function getCalculatedPosts()
    {
        $posts = $this->getRelevantPosts();
        $computedPosts = [];
        foreach ($posts as $post) {
            $edge = $this->computeEdge($post);
            $computedPosts[] = $edge;
        }

        return $computedPosts;
    }

    // GET ALL THE POSTS WHERE TIME != 0
    private function getRelevantPosts()
    {
        $posts = \App\Post::where('time', '!=', 0)->get();

        return $posts;
    }

    // CALCULATE EDGES FUNCTION
    private function computeEdge($post)
    {
        $authId = auth()->id();

        $affinity = $this->getAffinity($authId, $post['user_id']);

        $edge = $post['weight'] * $affinity * $post['time'];

        $post['edge'] = $edge;

        return $post;
    }

    // GET THE USER AFFINITY
    private function getAffinity($authId, $postUserId)
    {
        $interaction = $this->getInteractionValue($authId, $postUserId);
        $followValue = $this->getFollowValue($authId, $postUserId);

        return $interaction + $followValue;
    }

    // GET THE FOLLOW VALUE
    private function getFollowValue($authId, $postUserId)
    {
        $result = $this->connect()->query("SELECT * FROM follows WHERE follower_id = $authId AND user_id = $postUserId");
        $check = $result->fetch_assoc();

        if ($check != null) {
            $value = 100;
        } else {
            $value = 1;
        }

        return $value;
    }

    // GET THE INTERACTION VALUE
    private function getInteractionValue($authId, $postUserId)
    {
        $result = $this->connect()->query("SELECT * FROM interactions WHERE user_id = $authId AND target_id = $postUserId");
        $check = $result->fetch_assoc();

        if ($check != null) {
            $value = $check['affinity'];
        } else {
            $value = 0;
        }

        return $value;
    }
}
