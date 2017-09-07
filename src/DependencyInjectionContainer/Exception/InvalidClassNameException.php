<?php

namespace Systream\DependencyInjectionContainer\Exception;


use Psr\Container\ContainerExceptionInterface;

class InvalidClassNameException extends \InvalidArgumentException implements ContainerExceptionInterface
{

}