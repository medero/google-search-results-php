<?php

declare(strict_types=1);

namespace SerpApi\Search;

/***
 * WalmartSearch search
 * @see https://serpapi.com/walmart-search-api
 */
class WalmartSearch extends BaseSearch
{
    public function __construct(string $api_key = null)
    {
        parent::__construct($api_key, 'walmart');
    }

    /***
     * Method is not supported.
     */
    public function get_location(string $q, int $limit): void
    {
        throw new SearchException("location is not currently supported by Walmart");
    }
}
