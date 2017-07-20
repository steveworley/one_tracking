<?php

namespace Drupal\one_tracking\Service;

use GuzzleHttp\Client;

class TrackingService {

  /**
   * @var \GuzzleHttp\Client
   */
  protected $httpClient;

  /**
   * The URL to the API endpoint.
   *
   * @var string
   */
  protected $trackingUrl = 'http://www.mocky.io/v2/59712d85100000030c71dc4c';

  /**
   * Tracking constructor.
   *
   * @param \GuzzleHttp\Client $http_client
   *   Guzzle HTTP client used for making API requests.
   */
  public function __construct(Client $http_client) {
    $this->httpClient = $http_client;
  }

  /**
   * Make a request to the API.
   *
   * @param array $params
   *   Query params.
   *
   * @return \Psr\Http\Message\StreamInterface
   */
  public function fetch($params = []) {
    $result = $this->httpClient->get($this->trackingUrl);
    return $result->getBody();
  }
}
