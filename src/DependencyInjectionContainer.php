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
			if (!isset($this->binds[$className])) {
				throw new DependencyNotFoundException(sprintf('%s dependency not binded.', $className));
			}
			$this->cache[$className] = $this->binds[$className]();
		}

		return $this->cache[$className];
	}
}