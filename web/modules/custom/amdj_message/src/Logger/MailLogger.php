<?php

namespace Drupal\amdj_message\Logger;

use Drupal\Component\Render\FormattableMarkup;
use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Core\Logger\LogMessageParserInterface;
use Drupal\Core\Logger\RfcLoggerTrait;
use Drupal\Core\Logger\RfcLogLevel;
use Psr\Log\LoggerInterface;

class MailLogger implements LoggerInterface
{
    use RfcLoggerTrait;

  /**
   * The message parser.
   *
   * @var \Drupal\Core\Logger\LogMessageParserInterface
   */
  protected $parser;

  /**
   * The config factory.
   *
   * @var \Drupal\Core\Config\ConfigFactoryInterface
   */
  protected $configFactory;

  /**
   * MailLogger constructor.
   *
   * @param \Drupal\Core\Logger\LogMessageParserInterface $parser
   * The message parser.
   * @param \Drupal\Core\Config\ConfigFactoryInterface $config_factory
   */
  public function __construct(ConfigFactoryInterface $config_factory) {
    $this->parser = $parser;
    $this->configFactory = $config_factory;
  }

    /**
     * @inheritDoc
     */
    public function log($level, $message, array $context = []) {
        if ($level !== RfcLogLevel::ERROR) {
          return;
        }

        $to = $this->configFactory->get('system.site')->get('mail');
        $langcode = $this->configFactory->get('system.site')->get('langcode');
        $variables = $this->parser->parseMessagePlaceholders($message, $context);
        $markup = new FormattableMarkup($message, $variables);
        \Drupal::service('plugin.manager.mail')->mail('amdj_message', 'amdj_message_log', $to, $langcode, ['message' => $markup]);
    }
}
