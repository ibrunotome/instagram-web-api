<?php

namespace App\Web;

use GuzzleHttp\Client;

class InstagramWeb
{
    const BASE_URL = 'https://www.instagram.com';

    private $data;
    private $headers;
    protected $instagram;

    /**
     * @var Media;
     */
    public $media;

    /**
     * @var People;
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

    public function login()
    {
        $response = $this->instagram->get('/');
        $csrftoken = $response->getHeaders()['Set-Cookie'][1];
        $csrftoken = explode('=', $csrftoken)[1];
        $csrftoken = explode(';', $csrftoken)[0];

        $this->headers['Accept'] = '*/*';
        $this->headers['X-CSRFToken'] = $csrftoken;

        try {
            $response = $this->instagram->post('/accounts/login/ajax/', [
                'form_params' => [
                    'username' => $this->data['username'],
                    'password' => $this->data['password'],
                ],
            ]);

            var_dump($response);
        } catch (\Exception $exception) {
            echo $exception->getMessage();
        }
    }

    public function logout()
    {
        $this->instagram->get('/accounts/logout/ajax/');
    }

    public function getHome()
    {
        return $this->instagram->get('/?__a=1');
    }

    public function getUserByUsername($username)
    {
        return $this->instagram->get("/${username}/?__a=1");
    }

    public function getActivity()
    {
        return $this->instagram->get('/accounts/activity/?__a=1');
    }

    public function getProfile()
    {
        return $this->instagram->get('/accounts/edit/?__a=1');
    }

    public function updateProfile(array $data)
    {
        $acceptValues = [
            'first_name'       => '',
            'email'            => '',
            'username'         => '',
            'phone_number'     => '',
            'gender'           => '',
            'biography'        => '',
            'external_url'     => '',
            'chaining_enabled' => ''
        ];

        $data = array_intersect_key($data, $acceptValues);

        return $this->instagram->post('/accounts/edit/', ['form_params' => $data]);
    }

    public function changeProfilePhoto($url)
    {
        return $this->instagram->post('/accounts/web_change_profile_picture/',
            [
                'form_params' => ['profile_pic' => $url]
            ]);
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
