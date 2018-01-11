<?php

namespace InstagramWeb\Requests;

class Discover extends Instagram
{
    public function search($query)
    {
        return $this->instagram->get("/web/search/topsearch/?context=blended&query=${query}");
    }
}