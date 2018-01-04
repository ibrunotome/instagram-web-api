<?php

namespace App\Web;

class People extends InstagramWeb
{
    public function followApprove($userId)
    {
        return $this->instagram->post("/web/friendships/${userId}/approve/");
    }

    public function followIgnore($userId)
    {
        return $this->instagram->post("/web/friendships/${userId}/ignore/");
    }

    public function follow($userId)
    {
        return $this->instagram->post("/web/friendships/${userId}/follow/");
    }

    public function unfollow($userId)
    {
        return $this->instagram->post("/web/friendships/${userId}/unfollow/");
    }

    public function block($userId)
    {
        return $this->instagram->post("/web/friendships/${userId}/block/");
    }

    public function unblock($userId)
    {
        return $this->instagram->post("/web/friendships/${userId}/unblock/");
    }
}