<?php

namespace Drupal\amdj_message\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Core\Logger\LoggerChannelInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Configuration form definition for the greeting message.
 */
class GreetingConfigurationForm extends ConfigFormBase
{
  /**
   * The logger.
   *
   * @var \Drupal\Core\Logger\LoggerChannelInterface
   */
  protected $logger;

  /**
   * SalutationConfigurationForm constructor.
   *
   * @param \Drupal\Core\Config\ConfigFactoryInterface $config_factory
   *   The factory for configuration objects.
   * @param \Drupal\Core\Logger\LoggerChannelInterface $logger
   *   The logger.
   */
  public function __construct(ConfigFactoryInterface $config_factory, LoggerChannelInterface $logger) {
    parent::__construct($config_factory);
    $this->logger = $logger;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('config.factory'),
      $container->get('amdj_message.logger.channel.amdj_message')
    );
  }

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
    $this->config('amdj_message.custom_greeting')
      ->set('greeting', $form_state->getValue('greeting'))
      ->save();
    parent::submitForm($form, $form_state);
    $this->logger->info('The Amdj Message salutation has been changed to @message.', ['@message' => $form_state->getValue('greeting')]);

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
