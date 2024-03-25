<?php
  require __DIR__ . '/vendor/autoload.php';

  use SerpApi\Search\GoogleSearch;

  $client = new GoogleSearch($apiKey);
  $query = ["q" => "coffee","location"=>"Austin,Texas"];
  $response = $client->get_json($query);
  print_r($response);
 ?>