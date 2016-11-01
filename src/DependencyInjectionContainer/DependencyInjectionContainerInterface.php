<?php

namespace Systream\DependencyInjectionContainer;


interface DependencyInjectionContainerInterface
{

	/**
	 * @param string $className
	 * @param \Closure $closure
	 * @return void
	 */
	public function bind($className, \Closure $closure);

	/**
	 * @param string $className
	 * @return mixed
	 */
	public function get($className);
}