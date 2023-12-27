<?php

class VirtualBoard
{
	/**
	 * @var VirtualButton[]
	 */
	private array $buttonList;

	private static ?VirtualBoard $instance = null;

	private static string $cancelButton = 'ctrZ';
	private static array $lastButtonList = [];

	public static function getCancelButton(): string
	{
		return self::$cancelButton;
	}

	public static function setCancelButton(string $cancelButton): void
	{
		self::$cancelButton = $cancelButton;
	}

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
		if ($button === self::$cancelButton && isset(self::$lastButtonList))
		{
			$this->buttonList[array_pop(self::$lastButtonList)]->cancel();
		}

		if (isset($this->buttonList[$button]))
		{
			self::$lastButtonList[] = $button;
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
	protected $cancelFunction;

	public function __construct(string $originalButton, callable $executeFunction, callable $cancelFunction = null)
	{
		$this->originalButton = $originalButton;
		$this->executeFunction = $executeFunction;
		$this->cancelFunction = $cancelFunction;
	}

	public function getOriginalButton(): string
	{
		return $this->originalButton;
	}

	public function execute():void
	{
		($this->executeFunction)();
	}

	public function cancel(): void
	{
		if (!isset($this->cancelFunction) || !is_callable($this->cancelFunction))
		{
			return;
		}

		($this->cancelFunction)();
	}
}

function start(): void
{
	VirtualBoard::getInstance()->addButton(new VirtualButton('a', function () { echo "Имитация замены клавиши a\n"; }, function () { echo "Отмена действия клавиши a\n"; }));
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
