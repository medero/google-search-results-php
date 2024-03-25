<?php

declare(strict_types=1);

namespace SerpApi\Search;

/***
 * Ebay search
 * @see https://serpapi.com/ebay-search-api
 */
class EbaySearch extends BaseSearch
{
    public function __construct(string $api_key = null)
    {
        parent::__construct($api_key, 'ebay');
    }

    /***
     * Method is not supported.
     */
    public function get_location(string $q, int $limit): mixed
    {
        throw new SearchException("location is not currently supported by Ebay");
    }
}
