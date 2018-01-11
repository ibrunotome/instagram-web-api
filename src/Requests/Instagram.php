<?php

namespace InstagramWeb\Requests;

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

    /**
     * @var Discover
     */
    public $discover;

    /**
     * @var Hashtag
     */
    public $hashtag;

    /**
     * @var Timeline
     */
    public $timeline;

    /**
     * @var Location
     */
    public $location;

    public function __construct()
    {
        $this->headers = [
            'Accept-Language'  => 'en-US,en;q=0.9',
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

        $this->account = new Account();
        $this->discover = new Discover();
        $this->hashtag = new Hashtag();
        $this->location = new Location();
        $this->media = new Media();
        $this->people = new People();
        $this->timeline = new Timeline();
    }
}
