<?php

namespace Drupal\amdj_message\Plugin\Block;

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

class AmdjMessageGreetingBlock extends BlockBase implements ContainerFactoryPluginInterface
{
  /**
   * The Amdj service.
   *
   * @var \Drupal\amdj_message\AmdjMessageGreeting
   */
  protected $salutation;
  /**
   * Constructs a AmdjMessageGreetingBlock.
   */
  public function __construct(array $configuration, $plugin_id, $plugin_definition, AmdjMessageGreeting $greeting)
  {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
      $this->greeting = $greeting;
  }

  /**
     * {@inheritDoc}
     */
    public function build()
    {
      return [
        '#markup' => $this->greeting->getGreeting(),
      ];
    }

    /**
     * {@inheritDoc}
     */
    public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition)
    {
      return new static(
        $configuration,
        $plugin_id,
        $plugin_definition,
        $container->get('amdj_message.greeting')
      );
    }
}
