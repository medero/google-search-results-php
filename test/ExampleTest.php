<?php

namespace SerpApi\Tests;

use SerpApi\Search\GoogleSearch;
use PHPUnit\Framework\TestCase;

class ExampleTest extends TestCase
{
    protected string $API_KEY;
    protected function setUp(): void
    {
        if(isset($_ENV["API_KEY"])) {
            $this->API_KEY = $_ENV["API_KEY"];
        } elseif (getenv('API_KEY')) {
            $this->API_KEY = getenv('API_KEY');
        } else {
            $this->API_KEY = "demo";
        }
    }

    public function test_google_image(): void
    {
        $client = new GoogleSearch($this->API_KEY);
        $data = $client->get_json([
          'q' => "Coffee",
          'tbm' => 'isch'
        ]);

        foreach($data->images_results as $image_result) {
            print_r($image_result->original);
            //to download the image:
            // `wget #{image_result[:original]}`
        }

        $this->assertGreaterThan(10, sizeof($data->images_results));
    }

}
