<?php

namespace Drupal\entity_order\EventSubscriber;

use Drupal\entity_order\Entity\EntityOrder;
use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;

/**
 * Class EntityOrderSubscriber.
 */
class EntityOrderSubscriber implements EventSubscriberInterface {


  /**
   * Constructs a new EntityOrderSubscriber object.
   */
  public function __construct() {

  }

  /**
   * {@inheritdoc}
   */
  static function getSubscribedEvents() {
    $events['kernel.request'] = ['onRequest'];

    return $events;
  }

  /**
   * This method is called whenever the kernel.request event is
   * dispatched.
   *
   * @param GetResponseEvent $event
   */
  public function onRequest(Event $event) {

    $request = $event->getRequest();

    $route_name = $request->get('_route'); // null
    switch ($route_name) {
      case 'entity.entity_order.add_form':
        $this->_checkProduct($event, $request);
        break;
    }
    return;
  }

  /**
   * @param GetResponseEvent $event
   * @param \Symfony\Component\HttpFoundation\Request $request
   */
  private function _checkProduct(Event $event, Request $request) {
    $orderId = $request->get(EntityOrder::PRODUCT_QUERY);
    if (!$orderId) {
      $destination = $request->get('destination') ? $request->get('destination') : '/';
      $response = new RedirectResponse($destination, 301);
      $event->setResponse($response);
    }
  }

}
