<?php

namespace Drupal\scales_generator;

class ScalesGenerator {
  public function getScales($key1, $key2, $key3) {
    $output = '<p>The scale is in the key of: ' . $key1 . '<p>';
    $output .= '<p>The scale is in the key of: ' . $key2 . '<p>';
    $output .= '<p>The scale is in the key of: ' . $key3 . '<p>';
    return $output;
  }
}
