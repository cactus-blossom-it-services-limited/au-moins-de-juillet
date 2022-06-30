<?php

namespace Drupal\Tests\amdj_message\Functional;


use Drupal\Tests\BrowserTestBase;

/**
 * Basic testing of the main Amdj page.
 *
 * @group amdj_message
 */
class AmdjMessagePageTest extends BrowserTestBase
{
  /**
   * {@inheritdoc}
   */
  protected static $modules = ['amdj_message', 'user'];

  /**
   * {@inheritdoc}
   */
  protected $defaultTheme = 'stable';

  /**
   * Tests the main Amdj page.
   */
  public function testPage() {
    $expected = $this->assertDefaultGreeting();
    $config = $this->config('amdj_message.custom_greeting');
    $config->set('greeting', 'Testing greeting');
    $config->save();
    $this->drupalGet('/message');
    $this->assertSession()->pageTextNotContains($expected);
    $expected = 'Testing message';
    $this->assertSession()->pageTextContains($expected);
  }
}
