<?php

namespace Drupal\one_tracking\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\one_tracking\Service\TrackingService;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\RequestStack;

class PageController extends ControllerBase {

  /**
   * @var \Drupal\one_tracking\Service\TrackingService
   */
  protected $trackingService;

  protected $requestStack;

  /**
   * Create an instance of the controller.
   *
   * @param \Drupal\one_tracking\Service\TrackingService $tracking_service
   *   The service to make API requests.
   */
  public function __construct(TrackingService $tracking_service, RequestStack $request_stack) {
    $this->trackingService = $tracking_service;
    $this->requestStack = $request_stack;
  }

  /**
   * Inject the tracking service into the page controller.
   *
   * @param \Symfony\Component\DependencyInjection\ContainerInterface $container
   *   The dependency injection interface.
   *
   * @return static
   */
  public static function create(ContainerInterface $container) {
    return new static (
      $container->get('one_tracking.tracking'),
      $container->get('request_stack')
    );
  }

  /**
   * Accessor method for the
   * @return \Drupal\one_tracking\Service\TrackingService
   */
  public function getTrackingService() {
    return $this->trackingService;
  }

  /**
   * Build the tracking page.
   *
   * @return array
   *   A render array for Drupal to render to the page.
   */
  public function tracking() {
    $service = $this->getTrackingService();
    $query_params = $this->requestStack->getCurrentRequest()->query->all();
    $result = $service->fetch($query_params);

    $build = [
      '#type' => 'markup',
      '#markup' => '<pre>' . \GuzzleHttp\json_encode($this->requestStack->getCurrentRequest()->query->all()). '</pre><pre>' . $result . '</pre>',
    ];

    return $build;
  }
}
