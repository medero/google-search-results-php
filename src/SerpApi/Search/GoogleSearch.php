<?php

declare(strict_types=1);

namespace SerpApi\Search;

/***
 * GoogleSearch engine
 * @see https://serpapi.com/search-api
 */
class GoogleSearch extends BaseSearch
{
    public function __construct(string $api_key)
    {
        parent::__construct($api_key, 'google');
    }
}
