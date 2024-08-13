<?php

declare(strict_types=1);

namespace SerpApi\Search;

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Exception\RequestException;

class BaseSearch
{
    /**
     * @var array<mixed>
     */
    protected array $options;
    protected string $api_key;
    protected string $engine;
    protected GuzzleClient $client;

    public function __construct(string $api_key = '', string $engine = 'google')
    {
        if (!$engine) {
            throw new SearchException("engine must be defined");
        }

        // register engine and api key
        $this->engine = $engine;

        if ($api_key) {
            $this->api_key = $api_key;
        }

        $this->client = new GuzzleClient([
            'base_uri' => 'https://serpapi.com',
            'headers' => [
                'User-Agent' => 'google-search-results-php/1.3.0',
            ],
            'verify' => false,
        ]);
    }

    public function set_serp_api_key(string $api_key): void
    {
        if ($api_key == null) {
            throw new SearchException("serp_api_key must have a value");
        }

        $this->api_key = $api_key;
    }

    /*
     * get_json
     * 
     * @param array $q
     * 
     * @return [Hash] search result "json like"
     */
    public function get_json(array $q): mixed
    {
        return $this->search('json', $q);
    }

    /***
     * get_html
     * 
     * @param array $q
     * 
     * @returns [String] raw html search result // TODO: Meder
     */
    public function get_html(array $q): mixed
    {
        return $this->search('html', $q);
    }

    /***
     * Get location using Location API
     * 
     * @param string $q
     * @param int $limit
     * 
     * @returns mixed
     */
    public function get_location(string $q, int $limit): mixed
    {
        $query = [
          'q' => $q,
          'limit' => $limit
        ];
        return $this->query("/locations.json", 'json', $query);
    }

    /***
     * Retrieve search result from the Search Archive API
     * 
     * @param int|string $search_id
     * 
     * @returns mixed
     */
    public function get_search_archive(int|string $search_id): mixed
    {
        return $this->query("/searches/$search_id.json", 'json', []);
    }

    /***
     * Get account information using Account API
     */
    public function get_account(): mixed
    {
        return $this->query('/account', 'json', []);
    }

    /**
     * Run a search
     * @param string $output
     * @param array $q
     * 
     * @returns mixed
     */
    public function search(string $output, array $q): mixed
    {
        return $this->query('/search', $output, $q);
    }

    /**
     * @param string $path
     * @param string $output
     * @param mixed $q
     * 
     * @returns mixed
     */
    public function query(string $path, string $output, mixed $q): mixed
    {
        if ($this->api_key == null) {
            throw new SearchException(
              "serp_api_key must be defined either in the constructor or by the method set_serp_api_key"
            );
        }

        $default_q = [
          'output'  => $output,
          'source'  => 'php',
          'api_key' => $this->api_key,
          'engine'  => $this->engine
        ];
        $q = array_merge($default_q, $q);

        // GET https://serpapi.com/search?q=Coffee&location=Portland&format=json&source=php&engine=google&serp_api_key=demo
        try {
            $response = $this->client->request('GET', $path, [
                'query' => $q
            ]);

            $statusCode = $response->getStatusCode();
            $body = (string)$response->getBody();

            if ($statusCode === 200) {
                return $output === 'json' ? json_decode($body) : $body;
            }

            if ($statusCode === 400 && $output === 'json') {
                $error = json_decode($body);
                $msg = $error['error'] ?? 'Unknown error';
                throw new SearchException($msg);
            }

            throw new SearchException("Unexpected response: $body");

        } catch (RequestException $e) {
            throw new SearchException($e->getMessage());
        }
    }
}
