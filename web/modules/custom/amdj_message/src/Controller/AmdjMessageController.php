<?php

namespace Drupal\amdj_message\Controller;

use Drupal\amdj_message\AmdjMessageGreeting;
use Drupal\Core\Controller\ControllerBase;
use Psr\Container\ContainerInterface;

/**
 * Controller for the Amdj message
 */

class AmdjMessageController extends ControllerBase
{
  /**
   * @var \Drupal\amdj_message\AmdjMessageGreeting
   */
  protected $greeting;
  /**
   * AmdjMessageController constructor.
   *
   * @param \Drupal\amdj_message\AmdjMessageGreeting $greeting
   */
  public function __construct(AmdjMessageGreeting $greeting) {
    $this->greeting = $greeting;
  }

  /**
   * {@inheritdoc}
   */
  public static function create (ContainerInterface $container)
  {
    return new static(
      $container->get('amdj_message.greeting')
    );
  }

  /**
   * Amdj Message.
   *
   * @return array
   *   The message.
   */
  public function amdjMessage() {
    return $this->greeting->getGreetingComponent();
  }
}
