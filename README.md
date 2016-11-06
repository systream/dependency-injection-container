# Repository
For saving models with repository pattern.

## Installation

You can install this package via [packagist.org](https://packagist.org/packages/systream/dependency-injection-container) with [composer](https://getcomposer.org/).

`composer require systream/dependency-injection-container`

composer.json:

```json
"require": {
    "systream/dependency-injection-container": "1.*"
}
```

This library requires `php 5.6` or higher, but also works on php 5.4.

## Usage

```php
$di = new DependencyInjectionContainer();
$di->bind(FixtureTestInterface::class, function () {
	return new ObjectA();
});

$di->has(FixtureTestInterface::class); // will return true

$instance = $di->get(FixtureTestInterface::class); // will return ObjectA instance 
```

### Create

```php

class TestObjectB {
	public function __construct(FixtureTestInterface $test) {
	}
}

$di = new DependencyInjectionContainer();
$di->bind(FixtureTestInterface::class, function () {
	return new ObjectA();
});

$testObject = $di->create(TestObjectB::class); 
```

## Test

[![Build Status](https://travis-ci.org/systream/dependency-injection-container.svg?branch=master)](https://travis-ci.org/systream/dependency-injection-container)

