<?php

class VirtualBoard
{
	/**
	 * @var VirtualButton[]
	 */
	private array $buttonList;

	private static ?VirtualBoard $instance = null;

	static public function getInstance(): VirtualBoard
	{
		if (!isset(self::$instance))
		{
			self::$instance = new VirtualBoard();
		}

		return self::$instance;
	}

	private function __construct()
	{
		$this->buttonList = [];
	}

	public function pressButton(string $button): void
	{
		if (isset($this->buttonList[$button]))
		{
			$this->buttonList[$button]->execute();
		}
	}

	public function addButton(VirtualButton $button): void
	{
		$this->buttonList[$button->getOriginalButton()] = $button;
	}
}

class VirtualButton
{
	protected string $originalButton;
	protected $executeFunction;

	public function __construct(string $originalButton, callable $executeFunction)
	{
		$this->originalButton = $originalButton;
		$this->executeFunction = $executeFunction;
	}

	public function getOriginalButton(): string
	{
		return $this->originalButton;
	}

	public function execute():void
	{
		($this->executeFunction)();
	}
}

function start(): void
{
	VirtualBoard::getInstance()->addButton(new VirtualButton('a', function () { echo "Имитация замены клавиши a\n"; }));
	VirtualBoard::getInstance()->addButton(new VirtualButton('A', function () { echo "Имитация замены клавиши shift + a\n"; }));
	VirtualBoard::getInstance()->addButton(new VirtualButton('e', function () { echo "Имитация замены клавиши e\n"; }));
	VirtualBoard::getInstance()->addButton(new VirtualButton('E', function () { exec('explorer'); }));

	while (true)
	{
		$command = readline();

		if ($command === 'exit')
		{
			break;
		}

		VirtualBoard::getInstance()->pressButton($command);
	}
}

start();
