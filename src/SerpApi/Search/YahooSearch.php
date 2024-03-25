<?php

declare(strict_types=1);

namespace SerpApi\Search;

/***
 * Yahoo search
 * @see https://serpapi.com/yahoo-search-api
 */
class YahooSearch extends BaseSearch
{
    public function __construct(string $api_key = null)
    {
        parent::__construct($api_key, 'yahoo');
    }

    /***
     * Method is not supported.
     */
    public function get_location(string $q, int $limit): mixed
    {
        throw new SearchException("location is not currently supported by Yahoo");
    }
}
