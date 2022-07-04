<?php

namespace Drupal\amdj_message\EventSubscriber;

use Drupal\Core\Session\AccountProxyInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;

/**
 * Subscribes to the Kernel Request
 * event and redirects to the home page
 * when the user has the role "outsider".
 */
class AmdjMessageRedirectSubscriber implements EventSubscriberInterface
{
  /**
   * @var \Drupal\Core\Session\AccountProxyInterface
   */
  protected $currentUser;
  /**
   * AmdjMessageRedirectSubscriber constructor.
   *
   * @param \Drupal\Core\Session\AccountProxyInterface $currentUser
   */
  public function __construct(AccountProxyInterface $currentUser) {
    $this->currentUser = $currentUser;
  }
  /**
   * {@inheritdoc}
   */
  public static function getSubscribedEvents() {
    $events['kernel.request'][] = ['onRequest', 0];
    return $events;
  }
  /**
   * Handler for the kernel request events.
   *
   * @param \Symfony\Component\HttpKernel\Event\GetResponseEvent $event
   */
  public function onRequest(GetResponseEvent $event) {
    $request = $event->getRequest();
    $path = $request->getPathInfo();
    if ($path !== '/message') {
      return;
    }
    $roles = $this->currentUser->getRoles();
    if (in_array('outsider', $roles)) {
      $event->setResponse(new RedirectResponse('/'));
    }
  }
}
