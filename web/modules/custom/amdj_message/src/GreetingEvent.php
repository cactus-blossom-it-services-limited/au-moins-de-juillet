<?php

namespace Drupal\amdj_message;

use Symfony\Component\EventDispatcher\Event;

/**
 * Event class to be dispatched from the AmdjMessageGreeting service.
 */
class GreetingEvent extends Event {

  const EVENT = 'amdj_message.greeting_event';

  /**
   * The greeting message.
   *
   * @var string
   */
  protected $message;

  /**
   * Returns the greeting message.
   *
   * @return mixed
   * The greeting message
   */
  public function getValue() {
    return $this->message;
  }

  /**
   * Sets the greeting message.
   *
   * @param mixed $message
   * The salutation message.
   */
  public function setValue($message) {
    $this->message = $message;
  }
}
