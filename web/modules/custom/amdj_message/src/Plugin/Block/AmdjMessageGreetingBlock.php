<?php

namespace Drupal\amdj_message\Plugin\Block;

use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\Core\Block\BlockBase;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\amdj_message\AmdjMessageGreeting;

/**
 * Au moins de juillet Greeting block.
 *
 * @Block(
 *   id = "amdj_message_block",
 *   admin_label = @Translation("Amdj greeting"),
 *   )
 */
class AmdjMessageGreetingBlock extends BlockBase implements ContainerFactoryPluginInterface {

  /**
   * The Amdj service.
   *
   * @var \Drupal\amdj_message\AmdjMessageGreeting
   */

  protected $salutation;

  /**
   * Constructs a AmdjMessageGreetingBlock.
   */
  public function __construct(array $configuration, $plugin_id, $plugin_definition, AmdjMessageGreeting $greeting) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->greeting = $greeting;
  }

  /**
   * {@inheritDoc}
   */
  public function build() {
    return [
      '#markup' => $this->greeting->getGreeting(),
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function defaultConfiguration() {
    return [
      'enabled' => 1,
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function blockForm($form, FormStateInterface $form_state) {
    $config = $this->getConfiguration();
    $form['enabled'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('Enabled'),
      '#description' => $this->t('Check this box if you want to enable this feature.'),
      '#default_value' => $config['enabled'],
    ];
    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function blockSubmit($form, FormStateInterface $form_state) {
    $this->configuration['enabled'] = $form_state->getValue('enabled');
  }

  /**
   * {@inheritDoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('amdj_message.greeting')
      );
  }

}
