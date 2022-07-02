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
   * User object for our test.
   *
   * @var \Drupal\user\UserInterface
   */
  protected $webUser;


  /**
   * Tests the main Amdj page.
   */
  public function testPage() {
    // Verify that not logged in user cannot access message page.
    $this->drupalGet('/message');
    $this->assertSession()->statusCodeEquals(403);

    // Create a user with permissions to access 'simple' page and login.
    $this->webUser = $this->drupalCreateUser(['access content']);
    $this->drupalLogin($this->webUser);
    // Verify that user can access simple content.
    $this->drupalGet('/message');
    $this->assertSession()->statusCodeEquals(200);

    $expected = $this->assertDefaultGreeting();
    $config = $this->config('amdj_message.custom_greeting');
    $config->set('greeting', 'Testing greeting');
    $config->save();
    $this->drupalGet('/message');
    $this->assertSession()->pageTextNotContains($expected);
    $expected = 'Testing greeting';
    $this->assertSession()->pageTextContains($expected);
  }

  /**
   * Helper function to assert that the default salutation is present on the page.
   *
   * Returns the message so we can reuse it in multiple places.
   */
  protected function assertDefaultGreeting() {
    $this->drupalGet('/message');
    $this->assertSession()->pageTextContains('Au Moins De Juillet');
    $time = new \DateTime();
    $expected = '';
    if ((int) $time->format('G') >= 00 && (int) $time->format('G') < 12) {
      $expected = 'Good morning';
    }
    if ((int) $time->format('G') >= 12 && (int) $time->format('G') < 18) {
      $expected = 'Good afternoon';
    }

    if ((int) $time->format('G') >= 18) {
      $expected = "Good evening";
    }
    $expected .= ' world';
    $this->assertSession()->pageTextContains($expected);
    return $expected;
  }
}
