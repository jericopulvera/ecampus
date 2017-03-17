<?php

namespace App\Edgerank;

class EcampusEdgerank
{
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

        foreach ($posts as $post) {
            $edge = $this->computeEdge($post);
            $computedPosts[] = $edge;
        }

        return $computedPosts;
    }

    // GET ALL THE POSTS WHERE TIME != 0
    private function getRelevantPosts()
    {
        $results = $this->connect()->query('SELECT * FROM posts WHERE time > 0');
        $posts = $results->fetch_all(MYSQLI_ASSOC);

        return $posts;
    }

    // CALCULATE EDGES FUNCTION
    private function computeEdge($post)
    {
        $authId = $this->getAuthUserId();

        $affinity = $this->getAffinity($authId, $post['user_id']);

        $edge = $post['weight'] * $affinity * $post['time'];

        $post['edge'] = $edge;

        return $post;
    }
}
