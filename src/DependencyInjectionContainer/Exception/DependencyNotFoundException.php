<?php

namespace Systream\DependencyInjectionContainer\Exception;

use Psr\Container\NotFoundExceptionInterface;

class DependencyNotFoundException extends \RuntimeException implements NotFoundExceptionInterface
{

}