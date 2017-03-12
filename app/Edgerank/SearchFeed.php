<?php

namespace App\Edgerank;

class SearchFeed
{
    // CONNECT TO DATABASE
    private static function connect()
    {
        try {
            $server = '127.0.0.1';
            $username = 'homestead';
            $password = 'secret';
            $db = 'e-campus';

            return $db = mysqli_connect($server, $username, $password, $db);
        } catch (Exception $ex) {
            echo 'ERROR'.$ex->getMessage();
        }
    }

    // SORT THE POSTS BASED ON EDGES
    public function getRankedPosts($id)
    {
        $posts = $this->getCalculatedPosts($id);
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
    private function getCalculatedPosts($id)
    {
        $posts = $this->getRelevantPosts();
        $computedPosts = [];
        foreach ($posts as $post) {
            $edge = $this->computeEdge($post, $id);
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
    private function computeEdge($post, $id)
    {
        $authId = $id;

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
