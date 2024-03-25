<?php

declare(strict_types=1);

namespace SerpApi\Search;

use TCDent\RestClient\Client;

class BaseSearch
{
    /**
     * @var array<mixed>
     */
    protected array $options;
    protected string $api_key;
    protected string $engine;

    public function __construct(string $api_key = null, string $engine = 'google')
    {
        // register engine
        if ($engine) {
            $this->engine = $engine;
        } else {
            throw new SearchException("engine must be defined");
        }

        // register private api key
        if ($api_key) {
            $this->api_key = $api_key;
        }
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
        $decode_format = $output == 'json' ? 'json' : 'php';

        if ($this->api_key == null) {
            throw new SearchException(
              "serp_api_key must be defined either in the constructor or by the method set_serp_api_key"
            );
        }

        $api = new Client([
            'base_url' => "https://serpapi.com",
            'user_agent' => 'google-search-results-php/1.3.0',
            'curl_options' => [
              CURLOPT_SSL_VERIFYHOST => 0,
              CURLOPT_SSL_VERIFYPEER => 0,
            ]
        ]);

        $default_q = [
          'output'  => $output,
          'source'  => 'php',
          'api_key' => $this->api_key,
          'engine'  => $this->engine
        ];
        $q = array_merge($default_q, $q);
        $result = $api->get($path, $q);

        // GET https://serpapi.com/search?q=Coffee&location=Portland&format=json&source=php&engine=google&serp_api_key=demo
        if ($result->info->http_code == 200) {
            // html response
            if ($decode_format == 'php') {
                return $result->response;
            }
            // json response
            return $result->decode_response();
        }

        if ($result->info->http_code == 400 && $output == 'json') {
            $error = $result->decode_response();
            $msg = $error->error;
            throw new SearchException($msg);
        }

        throw new SearchException("Unexpected exception: $result->response");
    }
}
