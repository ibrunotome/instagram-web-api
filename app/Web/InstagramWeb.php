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
        return $this->httpClient->get("/${username}/?__a=1");
    }

    public function getActivity()
    {
        return $this->httpClient->get('/accounts/activity/?__a=1');
    }

    public function getProfile()
    {
        return $this->httpClient->get('/accounts/edit/?__a=1');
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

        return $this->httpClient->post('/accounts/edit/', ['form_params' => $data]);
    }

    public function changeProfilePhoto($url)
    {
        return $this->httpClient->post('/accounts/web_change_profile_picture/',
            [
                'form_params' => ['profile_pic' => $url]
            ]);
    }

    public function deleteMedia($mediaId)
    {
        return $this->httpClient->post("/create/${mediaId}/delete/");
    }

    public function getMediaFeedByLocation($locationId)
    {
        return $this->httpClient->get("/explore/locations/${locationId}/?__a=1");
    }

    public function getMediaFeedByHashtag($hashtag)
    {
        return $this->httpClient->get("/explore/tags/${hashtag}/?__a=1");
    }

    public function getMediaByShortcode($shortcode)
    {
        return $this->httpClient->get("/p/${shortcode}/?__a=1");
    }

    public function comment($mediaId, $text)
    {
        return $this->httpClient->post("/web/comments/${mediaId}/add/", ['form_params' => ['comment_text' => $text]]);
    }

    public function deleteComment($mediaId, $commentId)
    {
        return $this->httpClient->post("/web/comments/${mediaId}/delete/${commentId}/");
    }

    public function followApprove($userId)
    {
        return $this->httpClient->post("/web/friendships/${userId}/approve/");
    }

    public function followIgnore($userId)
    {
        return $this->httpClient->post("/web/friendships/${userId}/ignore/");
    }

    public function follow($userId)
    {
        return $this->httpClient->post("/web/friendships/${userId}/follow/");
    }

    public function unfollow($userId)
    {
        return $this->httpClient->post("/web/friendships/${userId}/unfollow/");
    }

    public function block($userId)
    {
        return $this->httpClient->post("/web/friendships/${userId}/block/");
    }

    public function unblock($userId)
    {
        return $this->httpClient->post("/web/friendships/${userId}/unblock/");
    }
}
