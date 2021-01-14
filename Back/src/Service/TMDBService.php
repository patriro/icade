<?php

namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

class TMDBService
{
    private $httpClient;

    private $apiKey;

    public function __construct(HttpClientInterface $httpClient, $apiKey)
    {
        $this->httpClient = $httpClient;
        $this->apiKey = $apiKey;
    }

    public function findAllGenres()
    {
        try {
            $response = $this->httpClient->request(
                'GET',
                'https://api.themoviedb.org/3/genre/movie/list?api_key=5da2ecaef1b84326dfa73e2a59680d72&language=fr'
            );
            $headers = $response->getHeaders();

            return $response;
        } catch (TransportExceptionInterface $e) {
            throw $e;
        }
    }

    public function findAllMovies()
    {
        try {
            $response = $this->httpClient->request(
                'GET',
                'https://api.themoviedb.org/3/movie/popular?api_key=5da2ecaef1b84326dfa73e2a59680d72&language=fr'
            );
            $headers = $response->getHeaders();

            return $response;
        } catch (TransportExceptionInterface $e) {
            throw $e;
        }
    }
}
