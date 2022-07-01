<?php

namespace Drupal\amdj_message;

use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Core\StringTranslation\StringTranslationTrait;

/**
 * Prepares the greeting.
 */
class AmdjMessageGreeting
{
  use StringTranslationTrait;

  /**
   * @var \Drupal\Core\Config\ConfigFactoryInterface
   */
  protected $configFactory;

  /**
   * AmdjMessageGreeting constructor.
   *
   * @param \Drupal\Core\Config\ConfigFactoryInterface $config_factory
   */
  public function __construct(ConfigFactoryInterface $config_factory)
  {
    $this->configFactory = $config_factory;
  }

  /**
   * Returns the greeting
   */
  public function getGreeting()
  {
    $config = $this->configFactory->get('amdj_message.custom_greeting');
    $greeting = $config->get('greeting');
    if ($greeting !== "" && $greeting)
    {
      return $greeting;
    }
    $time = new \DateTime();
    if ((int)$time->format('G') >= 00
      && (int)$time->format('G') < 12) {
      return $this->t('Good morning world');
    }
    if ((int)$time->format('G') >= 12
      && (int)$time->format('G') < 18) {
      return $this->t("Good afternoon world");
    }
    if ((int)$time->format('G') >= 18) {
      return $this->t('Good evening world');
    }
  }

}
