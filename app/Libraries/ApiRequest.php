<?php

namespace App\Libraries;

use GuzzleHttp\Client;

class ApiRequest
{

    protected $client;
    protected $url;

    public function __construct()
    {
        $this->client = new Client();
        $this->url = getenv("api.url");
    }


    public function login($username, $password)
    {

        $loginUrl = $this->url . "api/login";

        try {

            $response = $this->client->post(
                $loginUrl,
                [
                    'form_params' => [
                        'username' => $username,
                        'password' => $password,
                        "level" => ["operator"]
                    ],
                    'headers' => [
                        'User-Agent' => 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/51.0.2704.103 Safari/537.36',
                        'Content-Type' => 'application/x-www-form-urlencoded',
                        'Accept' => '/',
                        'Accept-Language' => 'en-US,en;q=0.8,hi;q=0.6,und;q=0.4',
                        'cookies' => true,
                    ],
                ]
            );

            if ($response->getStatusCode() == 200) {

                return [
                    'success' => true,
                    'message' => 'Berhasil Login!',
                    'level' => 'operator'
                ];
            }
        } catch (\Exception $ex) {

            if ($ex->getCode() == 400) {
                return [
                    "success" => false,
                    'message' => "Username atau password salah!"
                ];
            } else {

                return [
                    "success" => false,
                    'message' => $ex->getMessage()
                ];
            }
        }

        try {

            $response = $this->client->post(
                $loginUrl,
                [
                    'form_params' => [
                        'username' => $username,
                        'password' => $password,
                        "level" => ["mahasiswa"]
                    ],
                    'headers' => [
                        'User-Agent' => 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/51.0.2704.103 Safari/537.36',
                        'Content-Type' => 'application/x-www-form-urlencoded',
                        'Accept' => '/',
                        'Accept-Language' => 'en-US,en;q=0.8,hi;q=0.6,und;q=0.4',
                        'cookies' => true,
                    ],
                ]
            );

            if ($response->getStatusCode() == 200) {

                return [
                    'success' => true,
                    'message' => 'Berhasil Login!',
                    'level' => 'mahasiswa'
                ];
            }
        } catch (\Exception $ex) {

            if ($ex->getCode() == 400) {
                return [
                    "success" => false,
                    'message' => "Username atau password salah!"
                ];
            } else {

                return [
                    "success" => false,
                    'message' => $ex->getMessage()
                ];
            }
        }
    }
}
