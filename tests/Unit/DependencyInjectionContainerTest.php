<?php

namespace Tests\Systream\Unit;


use Systream\DependencyInjectionContainer;
use Tests\Systream\Unit\Fixtures\FixtureTestInterface;
use Tests\Systream\Unit\Fixtures\ObjectA;
use Tests\Systream\Unit\Fixtures\ObjectB;
use Tests\Systream\Unit\Fixtures\TestObjectA;

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
	public function NotExists()
	{
		$di = new DependencyInjectionContainer();
		$di->get(FixtureTestInterface::class);
	}

	/**
	 * @test
	 * @expectedException \InvalidArgumentException
	 */
	public function add_badClassName()
	{
		$di = new DependencyInjectionContainer();
		$di->bind('', function () {
			return new ObjectA();
		});
	}

	/**
	 * @test
	 * @expectedException \InvalidArgumentException
	 */
	public function add_badClassName_spaces()
	{
		$di = new DependencyInjectionContainer();
		$di->bind('  ', function () {
			return new ObjectA();
		});
	}

	/**
	 * @test
	 * @expectedException \InvalidArgumentException
	 */
	public function add_badClassName_notString()
	{
		$di = new DependencyInjectionContainer();
		$di->bind(new \stdClass(), function () {
			return new ObjectA();
		});
	}

	/**
	 * @test
	 */
	public function has_found()
	{
		$di = new DependencyInjectionContainer();
		$di->bind(FixtureTestInterface::class, function () {
			return new ObjectA();
		});

		$this->assertTrue($di->has(FixtureTestInterface::class));
	}

	/**
	 * @test
	 */
	public function has_notFound()
	{
		$di = new DependencyInjectionContainer();
		$this->assertFalse($di->has(FixtureTestInterface::class));
	}

	/**
	 * @test
	 */
	public function create_full()
	{
		$di = new DependencyInjectionContainer();
		$di->bind(FixtureTestInterface::class, function () {
			return new ObjectA();
		});

		$di->bind(ObjectB::class, function () {
			return new ObjectB();
		});

		$testObject = $di->create(TestObjectA::class);
		$this->assertInstanceOf(TestObjectA::class, $testObject);
		$this->assertInstanceOf(ObjectA::class, $testObject->a);
	}

	/**
	 * @test
	 * @expectedException \RuntimeException
	 */
	public function create_CannotBind()
	{
		$di = new DependencyInjectionContainer();
		$di->bind(FixtureTestInterface::class, function () {
			return new ObjectA();
		});

		$di->create(TestObjectA::class);
	}
}
