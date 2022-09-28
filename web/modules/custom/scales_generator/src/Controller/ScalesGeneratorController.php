<?php

namespace Drupal\scales_generator\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\scales_generator\ScalesGenerator;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Response;

class ScalesGeneratorController extends ControllerBase {
  /**
   * @var ScalesGenerator
   */
  private $scalesGenerator;
  public function scales($key1, $key2, $key3) {
    $scales = $this->scalesGenerator->getScales($key1, $key2, $key3);
    return new Response($scales);
  }

  public static function create(ContainerInterface $container) {
    $scalesGenerator = $container->get('scales_generator.scales_generator');
    return new static($scalesGenerator);
  }

  public function __construct(ScalesGenerator $scalesGenerator) {
    $this->scalesGenerator = $scalesGenerator;
  }

}
