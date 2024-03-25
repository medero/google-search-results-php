<?php

declare(strict_types=1);

namespace SerpApi\Search;

/***
 * Yandex search
 * @see https://serpapi.com/yandex-search-api
 */
class YandexSearch extends BaseSearch
{
    public function __construct(string $api_key = null)
    {
        parent::__construct($api_key, 'yandex');
    }

    /***
     * Method is not supported.
     */
    public function get_location(string $q, int $limit): mixed
    {
        throw new SearchException("location is not currently supported by Yandex");
    }
}
