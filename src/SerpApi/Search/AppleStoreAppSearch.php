<?php

declare(strict_types=1);

namespace SerpApi\Search;

/***
* AppleStoreAppSearch engine
* @see https://serpapi.com/apple-app-store
*/
class AppleStoreAppSearch extends BaseSearch
{
    public function __construct(string $api_key = null)
    {
        parent::__construct($api_key, 'apple_app_store');
    }

    /***
     * Method is not supported.
     */
    public function get_location(string $q, int $limit): void
    {
        throw new SearchException("location is not currently supported by Apple Store");
    }
}
