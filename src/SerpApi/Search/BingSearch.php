<?php

declare(strict_types=1);

namespace SerpApi\Search;

/***
 * BingSearch engine
 * @see https://serpapi.com/bing-search-api
 */
class BingSearch extends BaseSearch
{
    public function __construct(string $api_key = null)
    {
        parent::__construct($api_key, 'bing');
    }
}
