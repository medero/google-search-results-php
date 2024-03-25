<?php

declare(strict_types=1);

namespace SerpApi\Search;

/***
 * Baidu engine
 * @see https://serpapi.com/baidu-search-api
 */
class BaiduSearch extends BaseSearch
{
    public function __construct(string $api_key = null)
    {
        parent::__construct($api_key, 'baidu');
    }

    /***
     * Method is not supported.
     */
    public function get_location(string $q, int $limit): mixed
    {
        throw new SearchException("location is not currently supported by Baidu");
    }
}
