<?php

declare(strict_types=1);

namespace SerpApi\Search;

/***
 * YouTube search
 * @see https://serpapi.com/youtube-search-api
 */
class YoutubeSearch extends BaseSearch
{
    public function __construct(string $api_key = null)
    {
        parent::__construct($api_key, 'youTube');
    }

    /***
     * Method is not supported.
     */
    public function get_location(string $q, int $limit): mixed
    {
        throw new SearchException("location is not currently supported by Youtube");
    }
}
