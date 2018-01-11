<?php

namespace InstagramWeb\Requests;

class Hashtag extends Instagram
{
    public function getFeedByHashtag($hashtag)
    {
        return $this->instagram->get("/explore/tags/${hashtag}/?__a=1");
    }
}