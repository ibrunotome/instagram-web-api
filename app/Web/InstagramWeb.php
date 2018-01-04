<?php

namespace App\Web;

use GuzzleHttp\Client;

class InstagramWeb
{
    const BASE_URL = 'https://www.instagram.com';

    private $data;
    private $headers;
    private $httpClient;

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

        $this->httpClient = new Client([
            'headers'  => $this->headers,
            'base_uri' => self::BASE_URL
        ]);
    }

    public function login()
    {
        $response = $this->httpClient->get('/');
        $csrftoken = $response->getHeaders()['Set-Cookie'][1];
        $csrftoken = explode('=', $csrftoken)[1];
        $csrftoken = explode(';', $csrftoken)[0];

        $this->headers['Accept'] = '*/*';
        $this->headers['X-CSRFToken'] = $csrftoken;

        try {
            $response = $this->httpClient->post('/accounts/login/ajax/', [
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
        $this->httpClient->get('/accounts/logout/ajax/');
    }

    public function getHome()
    {
        return $this->httpClient->get('/?__a=1');
    }

    public function getUserByUsername($username)
    {
        return $this->httpClient->get("/{$username}/?__a=1");
    }

    public function getActivity()
    {
        return $this->httpClient->get('/accounts/activity/?__a=1');
    }

    public function getMediaFeedByHashtag($hashtag)
    {
        return $this->httpClient->get("/explore/tags/{$hashtag}/?__a=1");
    }

    public function getProfile()
    {
        return $this->httpClient->get('/accounts/edit/?__a=1');
    }
}
