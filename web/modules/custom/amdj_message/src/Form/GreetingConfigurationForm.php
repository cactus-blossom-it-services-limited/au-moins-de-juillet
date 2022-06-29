<?php

namespace Drupal\amdj_message\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Configuration form definition for the greeting message
 */
class GreetingConfigurationForm extends ConfigFormBase
{
  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames()
  {
    return ['amdj_message.custom_greeting'];
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId()
  {
    return 'greeting_configuration_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state)
  {
    $config = $this->config('amdj_message.custom_greeting');
    $form['greeting'] = array(
      '#type' => 'textfield',
      '#title' => $this->t('Greeting'),
      '#description' => $this->t('Please provide the greeting to use.'),
      '#default_value' => $config->get('greeting'),
    );
    return parent::buildForm($form, $form_state);
  }

  public function submitForm(array &$form, FormStateInterface $form_state)
  {
    $this->config('amdj_message.custom_greeting')->set('greeting', $form_state->getValue('greeting'))
      ->save();
    parent::submitForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state)
  {
    $greeting =$form_state->getValue('greeting');
    if (strlen($greeting) > 20) {
      $form_state->setErrorByName('greeting', $this->t('This greeting is too long'));
    }
    parent::validateForm($form, $form_state);
  }

}
