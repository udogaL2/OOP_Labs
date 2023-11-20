<?php

class VirtualBoard extends VirtualKeyList implements VirtualBoardInterface
{
	public static function pressButton(string $button): void
	{
		$method = 'getButton' . $button;

		if (
			self::isKeyAvailbale($button)
			&& method_exists(VirtualBoard::class, $method)
		)
		{
			self::press(call_user_func('VirtualBoard::' . $method));
		}
	}

	private static function press(string $command): void
	{
		echo $command . "\n";
	}
}

class VirtualKeyList
{
	static protected array $availableKeyList = [
		'Q', 'W', 'E', 'R', 'T', 'Y', 'U', 'I', 'O',
		'P', 'A', 'S', 'D', 'F', 'G', 'H', 'J', 'K',
		'L', 'Z', 'X', 'C', 'V', 'B', 'N', 'M',
	];

	protected static function getButtonQ(): string
	{
		return 'A';
	}

	protected static function getButtonW(): string
	{
		return 'S';
	}

	protected static function getButtonE(): string
	{
		return 'D';
	}

	protected static function getButtonR(): string
	{
		return 'F';
	}

	protected static function getButtonT(): string
	{
		return 'G';
	}

	protected static function getButtonY(): string
	{
		return 'H';
	}

	protected static function getButtonU(): string
	{
		return 'J';
	}

	protected static function getButtonI(): string
	{
		return 'K';
	}

	protected static function getButtonO(): string
	{
		return 'L';
	}

	protected static function getButtonP(): string
	{
		return 'Z';
	}

	protected static function getButtonA(): string
	{
		return 'X';
	}

	protected static function getButtonS(): string
	{
		return 'C';
	}

	protected static function getButtonD(): string
	{
		return 'V';
	}

	protected static function getButtonF(): string
	{
		return 'B';
	}

	protected static function getButtonG(): string
	{
		return 'N';
	}

	protected static function getButtonH(): string
	{
		return 'M';
	}

	protected static function getButtonJ(): string
	{
		return 'Q';
	}

	protected static function getButtonK(): string
	{
		return 'W';
	}

	protected static function getButtonL(): string
	{
		return 'E';
	}

	protected static function getButtonZ(): string
	{
		return 'R';
	}

	protected static function getButtonX(): string
	{
		return 'T';
	}

	protected static function getButtonC(): string
	{
		return 'Y';
	}

	protected static function getButtonV(): string
	{
		return 'U';
	}

	protected static function getButtonB(): string
	{
		return 'I';
	}

	protected static function getButtonN(): string
	{
		return 'O';
	}

	protected static function getButtonM(): string
	{
		return 'P';
	}

	public static function isKeyAvailbale(string $button): bool
	{
		return in_array($button, self::$availableKeyList);
	}
}

interface VirtualBoardInterface
{
	public static function pressButton(string $button);
}


function start(): void
{
	while (true)
	{
		$command = readline();

		if ($command === 'exit')
		{
			break;
		}

		VirtualBoard::pressButton($command);
	}
}

start();
