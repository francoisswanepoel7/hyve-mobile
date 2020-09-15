<?php


namespace hyvemobile\utils;
use Symfony\Component\HttpClient\HttpClient;


class Request
{

    public static function concurrentGet2(string $uri, array $query_list, string $key) {
        $query_list_len = count($query_list);
        $offset = 0;
        $length = 20;

        $partition_query_list = array_slice($query_list, 0, 20);
        $responses = [];
        $content = [];
        $client = HttpClient::createForBaseUri($uri, []);
        foreach ($partition_query_list as $query) {
            $responses[] = $client->request('GET', $uri,['query' => [$key=> $query]]);
        }

        foreach ($responses as $response) {
            $statusCode = $response->getStatusCode();
            if ($statusCode < 300) {
                $result = json_decode($response->getContent(false), true);
                if (is_array($result) && array_key_exists($key, $result)) {
                    $content[$result[$key]] = $result;
                }
            }
        }
        return $content;
    }

    public static function concurrentGet(string $uri, array $query_list, string $key) {
        $responses = [];
        $content = [];
        $client = HttpClient::createForBaseUri($uri, []);
        foreach ($query_list as $query) {
            $responses[$query] = $client->request('GET', $uri,['query' => [$key=> $query]]);
        }

        foreach (array_keys($responses) as $query) {
            $statusCode = $responses[$query]->getStatusCode();
            if ($statusCode < 300) {
                print_r(json_decode($responses[$query]->getContent(false), true));
                $content[$query] = json_decode($responses[$query]->getContent(false), true);
            } else {
                $content[$query] = ['error' => $statusCode];
            }
        }
        var_dump($content);
        die();
        return $content;
    }
    public static function post(string $uri, array $query) {
        $client = HttpClient::createForBaseUri($uri, []);
        $response = $client->request('POST', $uri,['json' => $query]);
        $statusCode = $response->getStatusCode();
        if ($statusCode < 300) {
            return json_decode($response->getContent(false), true);
        } else {
            return ['error' => $statusCode];
        }

    }

}
