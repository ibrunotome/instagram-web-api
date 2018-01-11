<?php

namespace InstagramWeb\Requests;

class Location extends Instagram
{
    public function getFeedByLocation($locationId)
    {
        return $this->instagram->get("/explore/locations/${locationId}/?__a=1");
    }
}