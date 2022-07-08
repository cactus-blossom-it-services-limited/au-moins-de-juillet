<?php

namespace Drupal\Tests\amdj_message\Functional;

use Drupal\Tests\BrowserTestBase;

/**
 * Skeleton functional test.
 *
 * @group amdj_message
 * @group drupalize
 */
class SkeletonTest extends BrowserTestBase {
  /**
   * {@inheritdoc}
   */
  protected $defaultTheme = 'stark';

  /**
   * This test method fails, so we can be sure our test is discovered.
   */
  public function testFail() {
    $this->fail('The test runner found our test and failed it. Yay!');
  }

}
