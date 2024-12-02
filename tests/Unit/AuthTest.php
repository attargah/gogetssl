<?php

use GuzzleHttp\Client;

it('Auth Request Test', function () {

    $client = new Client();
    $config = $this->getConfig();

    $response = $client->post($config['url'] . '/auth', [
        'form_params' => [
            'user' => $config['username'],
            'pass' => $config['password'],
        ],
    ]);

    if ($response->getStatusCode() === 200) {
        $data = json_decode($response->getBody()->getContents(), true);

        expect(empty($data['key']))->toBeFalse();


    }

});

