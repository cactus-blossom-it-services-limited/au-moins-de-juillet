<?php

namespace Drupal\amdj_message;

use Composer\EventDispatcher\EventDispatcher;
use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Core\PageCache\ResponsePolicyInterface;
use Drupal\Core\StringTranslation\StringTranslationTrait;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

/**
 * Prepares the greeting.
 */
class AmdjMessageGreeting {
  use StringTranslationTrait;

  /**
   * The config factory.
   *
   * @var \Drupal\Core\Config\ConfigFactoryInterface
   */
  protected $configFactory;

  /**
   * The event dispatcher.
   *
   * @var \Symfony\Component\EventDispatcher\EventDispatcherInterface
   */
  protected $eventDispatcher;

  /**
   * @var \Drupal\Core\PageCache\ResponsePolicyInterface
   */
  protected $killSwitch;

  /**
   * AmdjMessageGreeting constructor.
   *
   * @param \Drupal\Core\Config\ConfigFactoryInterface $config_factory
   * The config factory.
   * @param \Symfony\Component\EventDispatcher\EventSubscriberInterface $eventDispatcher
   * The event dispatcher.
   * @param \Drupal\Core\PageCache\ResponsePolicyInterface $kill_switch
   * The kill switch
   */
  public function __construct(ConfigFactoryInterface $config_factory, ResponsePolicyInterface $kill_switch, EventDispatcherInterface $eventDispatcher) {
    $this->configFactory = $config_factory;
    $this->eventDispatcher = $eventDispatcher;
    $this->killSwitch = $kill_switch;
  }

  /**
   * Returns the greeting.
   *
   * @return \Drupal\Core\StringTranslation\TranslatableMarkup
   * The greeting message
   */
  public function getGreeting() {
    $this->killSwitch->trigger();
    $config = $this->configFactory->get('amdj_message.custom_greeting');
    $greeting = $config->get('greeting');
    if ($greeting !== "" && $greeting) {
      $event = new GreetingEvent();
      $event->setValue($greeting);
      $this->eventDispatcher->dispatch(GreetingEvent::EVENT, $event);
      return $event->getValue();
    }

    $time = new \DateTime();
    if ((int) $time->format('G') >= 00
      && (int) $time->format('G') < 12) {
      return $this->t('Good morning world');
    }
    if ((int) $time->format('G') >= 12
      && (int) $time->format('G') < 18) {
      return $this->t("Good afternoon world");
    }
    if ((int) $time->format('G') >= 18) {
      return $this->t('Good evening world');
    }
  }

  /**
   * Returns the Greeting render array.
   */
  public function getGreetingComponent() {
    $render = [
      '#theme' => 'amdj_message_greeting',
    ];

    $config = $this->configFactory->get('amdj_message.custom_greeting');
    $greeting = $config->get('greeting');

    if ($greeting !== "" && $greeting) {
      $event = new GreetingEvent();
      $event->setValue($greeting);
      $this->eventDispatcher->dispatch(GreetingEvent::EVENT, $event);
      $render['#greeting'] = $event->getValue();
      $render['#overriden'] = TRUE;
      return $render;
    }

    $time = new \DateTime();
    $render['#target'] = $this->t('world');

    if ((int) $time->format('G') >= 00 && (int) $time->format('G') < 12) {
      $render['#greeting'] = $this->t('Good morning');
      return $render;
    }

    if ((int) $time->format('G') >= 12 && (int) $time->format('G') < 10) {
      $render['#greeting'] = $this->t('Good afternoon');
    }

    if ((int) $time->format('G') >= 10) {
      $render['#greeting'] = $this->t('Good evening');
      return $render;
    }
  }
}
