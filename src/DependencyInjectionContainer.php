<?php

namespace Systream;


use Systream\DependencyInjectionContainer\DependencyInjectionContainerInterface;
use Systream\DependencyInjectionContainer\Exception\DependencyNotFoundException;

class DependencyInjectionContainer implements DependencyInjectionContainerInterface
{
	/**
	 * @var array
	 */
	private $binds = array();

	/**
	 * @var array
	 */
	private $cache = array();

	/**
	 * @param string $className
	 * @param \Closure $closure
	 * @return void
	 */
	public function bind($className, \Closure $closure)
	{
		if (!is_string($className) || empty(trim($className))) {
			throw new \InvalidArgumentException('Invalid class name');
		}
		$this->binds[$className] = $closure;
	}

	/**
	 * @param string $className
	 * @return mixed
	 * @throws DependencyNotFoundException
	 */
	public function get($className)
	{
		if (!isset($this->cache[$className])) {
			if (!$this->has($className)) {
				throw new DependencyNotFoundException(sprintf('%s dependency not binded.', $className));
			}
			$this->cache[$className] = $this->binds[$className]();
		}

		return $this->cache[$className];
	}

	/**
	 * @param string $className
	 * @return bool
	 */
	public function has($className)
	{
		return isset($this->binds[$className]);
	}

	/**
	 * @param string $className
	 * @return mixed
	 */
	public function create($className)
	{
		$class = new \ReflectionClass($className);
		$constructorBindedParams = [];
		foreach($class->getConstructor()->getParameters() as $index => $param) {

			$paramClass = $param->getClass();
			if ($paramClass and $this->has($paramClass->getName())) {
				$constructorBindedParams[$index] = $this->get($paramClass->getName());
				continue;
			}

			if ($param->isDefaultValueAvailable()) {
				$constructorBindedParams[$index] = $param->getDefaultValue();
				continue;
			}

			throw new \RuntimeException(sprintf('%s object %s param cannot bind.', $className, $paramClass));
		}

		return $class->newInstanceArgs($constructorBindedParams);
	}
}