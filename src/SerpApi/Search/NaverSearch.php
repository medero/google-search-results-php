<?php

declare(strict_types=1);

namespace SerpApi\Search;

/***
 * NaverSearch engine
 * @see https://serpapi.com/naver-search-api
 */
class NaverSearch extends BaseSearch
{
    public function __construct(string $api_key = null)
    {
        parent::__construct($api_key, 'naver');
    }

    /***
     * Method is not supported.
     */
    public function get_location(string $q, int $limit): void
    {
        throw new SearchException("location is not currently supported by Bing");
    }
}
