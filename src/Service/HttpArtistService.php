<?php

namespace App\Service;

use Symfony\Component\HttpClient\HttpClient;

class HttpArtistService
{
    const url = [
        'urlList' => 'https://mantle.madesimplegroup.com/artists/',
        'urlOne' => 'https://mantle.madesimplegroup.com/artists/{id}'
    ];

    public static function getArtistList(): array
    {
        $artists =  self::makeGetRequest(self::url['urlList']);

        $list = [];

        foreach ($artists as $key => $value) {
            $list[] = (object) $value;
        }

        return $list;
    }

    public static function getOneArtist($id): object
    {
        $url = str_replace('{id}', $id, self::url['urlOne']);
        return (object) self::makeGetRequest($url);
    }

    private static function makeGetRequest($url)
    {

        try {
            $client = HttpClient::create();

            $response = $client->request('GET', $url, [
                'headers' => [
                    'Authorization' => 'Basic ZGV2ZWxvcGVyOlpHVjJaV3h2Y0dWeQ=='
                ],
            ]);

            $statusCode = $response->getStatusCode();

            if ($statusCode == 200) {

                $content = $response->getContent();

                $content = json_decode($content, true);

                return $content;
            } else
                return null;
        } catch (\Throwable $th) {
            return null;
        }
    }
}
