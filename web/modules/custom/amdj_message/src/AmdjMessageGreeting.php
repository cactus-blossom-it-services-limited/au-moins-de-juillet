<?php

namespace Drupal\amdj_message;

use Drupal\Core\StringTranslation\StringTranslationTrait;

/**
 * Prepares the greeting.
 */
class AmdjMessageGreeting
{
  use StringTranslationTrait;
/**
 * Returns the greeting
 */
public function getGreeting() {
  $time = new \DateTime();
  if ((int) $time->format('G') >= 00
    && (int) $time->format('G') < 12) {
    return $this->t('Bonjour tout le monde');
  }
  if ((int) $time->format('G') >= 12
    && (int) $time->format('G') < 18) {
    return $this->t("C'est l'après-midi. Bonjour.");
  }
  if ((int) $time->format('G') >= 18) {
  return $this->t('Bonsoir tout le monde.');
  }
}

}
