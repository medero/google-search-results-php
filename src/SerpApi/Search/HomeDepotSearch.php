<?php

declare(strict_types=1);

namespace SerpApi\Search;

/***
 * HomeDepotSearch engine
 * @see https://serpapi.com/home-depot-search-api
 */
class HomeDepotSearch extends BaseSearch
{
    public function __construct(string $api_key = null)
    {
        parent::__construct($api_key, 'walmart'); // TODO: why is this walmart?
    }

    /***
     * Method is not supported.
     */
    public function get_location(string $q, int $limit): void
    {
        throw new SearchException("location is not currently supported by HomeDepot");
    }
}
