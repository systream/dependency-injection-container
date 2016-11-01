<?php

namespace Tests\Systream\Unit;


use Systream\DependencyInjectionContainer;
use Tests\Systream\Unit\Fixtures\FixtureTestInterface;
use Tests\Systream\Unit\Fixtures\ObjectA;
use Tests\Systream\Unit\Fixtures\ObjectB;

class DependencyInjectionContainerTest extends \PHPUnit_Framework_TestCase
{
	/**
	 * @test
	 */
	public function add()
	{
		$di = new DependencyInjectionContainer();
		$di->bind(FixtureTestInterface::class, function () {
			return new ObjectA();
		});

		$this->assertInstanceOf(ObjectA::class, $di->get(FixtureTestInterface::class));
	}

	/**
	 * @test
	 */
	public function add_Override()
	{
		$di = new DependencyInjectionContainer();
		$di->bind(FixtureTestInterface::class, function () {
			return new ObjectA();
		});

		$di->bind(FixtureTestInterface::class, function () {
			return new ObjectB();
		});

		$this->assertInstanceOf(ObjectB::class, $di->get(FixtureTestInterface::class));
	}

	/**
	 * @test
	 * @expectedException \Systream\DependencyInjectionContainer\Exception\DependencyNotFoundException
	 */
	public function add_NotExists()
	{
		$di = new DependencyInjectionContainer();
		$di->get(FixtureTestInterface::class);
	}
}
