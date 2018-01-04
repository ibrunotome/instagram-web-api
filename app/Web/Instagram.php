<?php

namespace App\Web;

use GuzzleHttp\Client;

class Instagram
{
    const BASE_URL = 'https://www.instagram.com';

    protected $data;
    protected $headers;
    protected $instagram;

    /**
     * @var Account
     */
    public $account;
    /**
     * @var Media
     */
    public $media;

    /**
     * @var People
     */
    public $people;

    public function __construct(array $data)
    {
        $this->data = $data;

        $this->headers = [
            'Accept-Language'  => 'en-US,en;q=0.9',
            'Content-Length'   => 0,
            'Content-Type'     => 'application/x-www-form-urlencoded',
            'Origin'           => 'https://www.instagram.com',
            'Referer'          => 'https://www.instagram.com/',
            'User-Agent'       => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_13_2) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/63.0.3239.84 Safari/537.36',
            'X-CSRFToken'      => '',
            'X-Instagram-AJAX' => 1,
        ];

        $this->instagram = new Client([
            'headers'  => $this->headers,
            'base_uri' => self::BASE_URL
        ]);
    }

    public function getHome()
    {
        return $this->instagram->get('/?__a=1');
    }

    public function getUserByUsername($username)
    {
        return $this->instagram->get("/${username}/?__a=1");
    }

    public function getFeedByLocation($locationId)
    {
        return $this->instagram->get("/explore/locations/${locationId}/?__a=1");
    }

    public function getFeedByHashtag($hashtag)
    {
        return $this->instagram->get("/explore/tags/${hashtag}/?__a=1");
    }

    public function search($query)
    {
        return $this->instagram->get("/web/search/topsearch/?context=blended&query=${query}");
    }
}
