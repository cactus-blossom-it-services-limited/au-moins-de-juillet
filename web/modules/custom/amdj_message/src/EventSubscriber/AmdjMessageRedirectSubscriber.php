<?php

namespace Drupal\amdj_message\EventSubscriber;

use Drupal\Core\Routing\LocalRedirectResponse;
use Drupal\Core\Routing\RouteMatchInterface;
use Drupal\Core\Session\AccountProxyInterface;
use Drupal\Core\Url;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;

/**
 * Event subscriber for redirecting to the homepage.
 *
 * Subscribes to the Kernel Request event and redirects to the home page
 * when the user has the role "outsider".
 */
class AmdjMessageRedirectSubscriber implements EventSubscriberInterface {
  /**
   * The current user.
   *
   * @var \Drupal\Core\Session\AccountProxyInterface
   */
  protected $currentUser;

  /**
   * The current route match.
   *
   * @var \Drupal\Core\Routing\RouteMatchInterface
   */
  protected $currentRouteMatch;

  /**
   * AmdjMessageRedirectSubscriber constructor.
   *
   * @param \Drupal\Core\Session\AccountProxyInterface $currentUser
   * The current user.
   * @param \Drupal\Core\Routing\RouteMatchInterface $currentRouteMatch
   * The current route match.
   */
  public function __construct(AccountProxyInterface $currentUser, RouteMatchInterface $currentRouteMatch) {
    $this->currentUser = $currentUser;
    $this->currentRouteMatch = $currentRouteMatch;
  }

  /**
   * {@inheritdoc}
   */
  public static function getSubscribedEvents() {
    $events[KernelEvents::REQUEST][] = ['onRequest', 0];
    return $events;
  }
  /**
   * Handler for the kernel request events.
   *
   * @param \Symfony\Component\HttpKernel\Event\GetResponseEvent $event
   * The event.
   */
  public function onRequest(GetResponseEvent $event) {
    $route_name = $this->currentRouteMatch->getRouteName();

    if ($route_name !== 'amdj_message.message') {
      return;
    }

    $roles = $this->currentUser->getRoles();
    if (in_array('outsider', $roles)) {
      $url = Url::fromUri('internal:/');
      $event->setResponse(new LocalRedirectResponse($url->toString()));
    }
  }
}
