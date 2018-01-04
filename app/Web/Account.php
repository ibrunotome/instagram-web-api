<?php

namespace App\Web;

class Account extends Instagram
{
    public function login()
    {
        $response = $this->instagram->get('/');
        $csrftoken = $response->getHeaders()['Set-Cookie'][1];
        $csrftoken = explode('=', $csrftoken)[1];
        $csrftoken = explode(';', $csrftoken)[0];

        $this->headers['Accept'] = '*/*';
        $this->headers['X-CSRFToken'] = $csrftoken;

        return $this->instagram->post('/accounts/login/ajax/', [
            'form_params' => [
                'username' => $this->data['username'],
                'password' => $this->data['password'],
            ],
        ]);
    }

    public function logout()
    {
        return $this->instagram->get('/accounts/logout/ajax/');
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
            ]
        );
    }
}