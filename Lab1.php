<?php

abstract class BaseDerivative
{
	protected float $derivative;

	function __construct(protected float $x, protected float $h, protected $func) {}

	final function calculateFunc(float $pos): float
	{
		$func = $this->func;
		return $func($pos);
	}

	abstract function calculate();

	final function getDerivative(): float
	{
		return $this->derivative;
	}
}


final class RightDerivative extends BaseDerivative
{
	function __construct(float $x, float $h, callable $func)
	{
		parent::__construct($x, $h, $func);
	}

	function calculate(): void
	{
		$this->derivative = ($this->calculateFunc($this->x + $this->h) - $this->calculateFunc($this->x)) / $this->h;
	}
}

final class LeftDerivative extends BaseDerivative
{
	function __construct(float $x, float $h, callable $func)
	{
		parent::__construct($x, $h, $func);
	}

	function calculate(): void
	{
		$this->derivative = ($this->calculateFunc($this->x) - $this->calculateFunc($this->x - $this->h)) / $this->h;
	}
}

final class CenterDerivative extends BaseDerivative
{
	function __construct(float $x, float $h, callable $func)
	{
		parent::__construct($x, $h, $func);
	}

	function calculate(): void
	{
		$this->derivative = ($this->calculateFunc($this->x + $this->h) - $this->calculateFunc($this->x - $this->h)) / (2 * $this->h);
	}
}

function main(): void
{
	$myFunc = fn($x) => $x * $x + 1;

	$derivativeList = [
		new LeftDerivative(1, 0.01, $myFunc),
		new RightDerivative(1, 0.01, $myFunc),
		new CenterDerivative(1, 0.01, $myFunc),
	];

	foreach ($derivativeList as $ferivative)
	{
		$ferivative->calculate();
		var_dump($ferivative::class, $ferivative->getDerivative());
	}

	$myFunc = fn($x) => $x * $x * $x + 3 * $x;

	$derivativeList = [
		new LeftDerivative(1, 0.01, $myFunc),
		new RightDerivative(1, 0.01, $myFunc),
		new CenterDerivative(1, 0.01, $myFunc),
	];

	foreach ($derivativeList as $ferivative)
	{
		$ferivative->calculate();
		var_dump($ferivative::class, $ferivative->getDerivative());
	}
}

main();