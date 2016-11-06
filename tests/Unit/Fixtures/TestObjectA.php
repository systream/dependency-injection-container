<?php


namespace Tests\Systream\Unit\Fixtures;


class TestObjectA
{

	/**
	 * @var ObjectA
	 */
	public $a;

	/**
	 * @var ObjectB
	 */
	public $b;

	public function __construct(FixtureTestInterface $a, ObjectB $b, $foo = null, array $bar = array())
	{
		$this->a = $a;
		$this->b = $b;
	}

}