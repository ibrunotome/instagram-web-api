<?php

namespace InstagramWeb\Requests;

class Timeline extends Instagram
{
    public function getHome()
    {
        return $this->instagram->get('/?__a=1');
    }
}