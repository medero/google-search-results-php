<?php

declare(strict_types=1);

namespace SerpApi\Search;

class SearchException extends \Exception
{
    public function __construct(string $message = "", int $code = 0, \Throwable $previous = null)
    {
        parent::__construct("SerpApi Search Exception: " . $message, $code, $previous);
    }
}
