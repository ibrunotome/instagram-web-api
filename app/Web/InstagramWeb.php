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
            'content-length'   => 0,
            'content-type'     => 'application/x-www-form-urlencoded',
            'origin'           => 'https://www.instagram.com',
            'Referer'          => 'https://www.instagram.com/',
            'User-Agent'       => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_13_2) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/63.0.3239.84 Safari/537.36',
            'X-CSRFToken'      => '',
            'X-Instagram-AJAS' => 1,
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
        $this->headers['accept'] = '*/*';

        try {
            $response = $this->httpClient->post('/accounts/login/ajax/', [
                'headers'     => $this->headers,
                'form_params' => [
                    'username' => $this->data['username'],
                    'password' => $this->data['password'],
                ],
            ]);

            var_dump($response);
        } catch (\Exception $exception) {
            var_dump($exception);
        }
    }
}