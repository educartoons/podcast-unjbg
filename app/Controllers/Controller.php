<?php

namespace App\Controllers;

use Interop\Container\ContainerInterface;

class Controller
{
  public $container;

  public function __construct(ContainerInterface $container)
  {
    $this->container = $container;
  }
}
