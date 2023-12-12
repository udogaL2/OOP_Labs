<?php
interface Control
{
	function setPosition(array $position): void;

	function getPosition(): array;
}

interface Form extends Control
{
	function addControl(Control $control): void;
}

interface Label extends Control
{
	function setText(string $text);

	function getText(): string;
}

interface TextBox extends Control
{
	function setText(string $text): void;

	function getText(): string;

	function onValueChanged(): void;
}

interface ControlFactory
{
	public function createForm(): Form;

	public function createLabel(): Label;

	public function createTextBox(): TextBox;
}

class WindowsFactory implements ControlFactory
{
	public function createForm(): Form
	{
		return new WindowsForm();
	}

	public function createLabel(): Label
	{
		return new WindowsLabel();
	}

	public function createTextBox(): TextBox
	{
		return new WindowsTextBox();
	}
}

class WindowsForm implements Form
{
	function setPosition(array $position): void
	{
		echo "Вызван метод setPosition у контролла WindowsForm\n";
	}

	function getPosition(): array
	{
		echo "Вызван метод getPosition у контролла WindowsForm\n";

		return [];
	}

	function addControl(Control $control): void
	{
		echo "Вызван метод addControl у контролла WindowsForm\n";
	}
}

class WindowsLabel implements Label
{
	function setPosition(array $position): void
	{
		echo "Вызван метод setPosition у контролла WindowsLabel\n";
	}

	function getPosition(): array
	{
		echo "Вызван метод getPosition у контролла WindowsLabel\n";

		return [];
	}

	function setText(string $text): void
	{
		echo "Вызван метод setText у контролла WindowsLabel\n";
	}

	function getText(): string
	{
		echo "Вызван метод getText у контролла WindowsLabel\n";

		return '';
	}
}

class WindowsTextBox implements TextBox
{
	function setPosition(array $position): void
	{
		echo "Вызван метод setPosition у контролла WindowsTextBox\n";
	}

	function getPosition(): array
	{
		echo "Вызван метод getPosition у контролла WindowsTextBox\n";

		return [];
	}

	function setText(string $text): void
	{
		echo "Вызван метод setText у контролла WindowsTextBox\n";
	}

	function getText(): string
	{
		echo "Вызван метод getText у контролла WindowsTextBox\n";

		return '';
	}

	function onValueChanged(): void
	{
		echo "Вызван метод onValueChanged у контролла WindowsTextBox\n";
	}
}

class LinuxFactory implements ControlFactory
{
	public function createForm(): Form
	{
		return new LinuxForm();
	}

	public function createLabel(): Label
	{
		return new LinuxLabel();
	}

	public function createTextBox(): TextBox
	{
		return new LinuxTextBox();
	}
}

class LinuxForm implements Form
{
	function setPosition(array $position): void
	{
		echo "Вызван метод setPosition у контролла LinuxForm\n";
	}

	function getPosition(): array
	{
		echo "Вызван метод getPosition у контролла LinuxForm\n";

		return [];
	}

	function addControl(Control $control): void
	{
		echo "Вызван метод addControl у контролла LinuxForm\n";
	}
}

class LinuxLabel implements Label
{

	function setPosition(array $position): void
	{
		echo "Вызван метод setPosition у контролла LinuxLabel\n";
	}

	function getPosition(): array
	{
		echo "Вызван метод getPosition у контролла LinuxLabel\n";

		return [];
	}

	function setText(string $text): void
	{
		echo "Вызван метод setText у контролла LinuxLabel\n";
	}

	function getText(): string
	{
		echo "Вызван метод getText у контролла LinuxLabel\n";

		return '';
	}
}

class LinuxTextBox implements TextBox
{
	function setPosition(array $position): void
	{
		echo "Вызван метод setPosition у контролла LinuxTextBox\n";
	}

	function getPosition(): array
	{
		echo "Вызван метод getPosition у контролла LinuxTextBox\n";

		return [];
	}

	function setText(string $text): void
	{
		echo "Вызван метод setText у контролла LinuxTextBox\n";
	}

	function getText(): string
	{
		echo "Вызван метод getText у контролла LinuxTextBox\n";

		return '';
	}

	function onValueChanged(): void
	{
		echo "Вызван метод onValueChanged у контролла LinuxTextBox\n";
	}
}

class MacosFactory implements ControlFactory
{
	public function createForm(): Form
	{
		return new MacosForm();
	}

	public function createLabel(): Label
	{
		return new MacosLabel();
	}

	public function createTextBox(): TextBox
	{
		return new MacosTextBox();
	}
}

class MacosForm implements Form
{
	function setPosition(array $position): void
	{
		echo "Вызван метод setPosition у контролла MacosForm\n";
	}

	function getPosition(): array
	{
		echo "Вызван метод getPosition у контролла MacosForm\n";

		return [];
	}

	function addControl(Control $control): void
	{
		echo "Вызван метод addControl у контролла MacosForm\n";
	}
}

class MacosLabel implements Label
{

	function setPosition(array $position): void
	{
		echo "Вызван метод setPosition у контролла MacosForm\n";
	}

	function getPosition(): array
	{
		echo "Вызван метод getPosition у контролла MacosForm\n";

		return [];
	}

	function setText(string $text): void
	{
		echo "Вызван метод setText у контролла MacosForm\n";
	}

	function getText(): string
	{
		echo "Вызван метод getText у контролла MacosForm\n";

		return '';
	}
}

class MacosTextBox implements TextBox
{
	function setPosition(array $position): void
	{
		echo "Вызван метод setPosition у контролла MacosForm\n";
	}

	function getPosition(): array
	{
		echo "Вызван метод getPosition у контролла MacosForm\n";

		return [];
	}

	function setText(string $text): void
	{
		echo "Вызван метод setText у контролла MacosForm\n";
	}

	function getText(): string
	{
		echo "Вызван метод getText у контролла MacosForm\n";

		return '';
	}

	function onValueChanged(): void
	{
		echo "Вызван метод onValueChanged у контролла MacosForm\n";
	}
}

class FactoryProducer
{
	/**
	 * @throws Exception
	 */
	public static function getFactory(string $osType) : ControlFactory
	{
		switch ($osType) {
			case 'Windows':
				return new WindowsFactory();
			case 'MacOS':
				return new MacosFactory();
			case 'Linux':
				return new LinuxFactory();
		}

		throw new Exception('Bad os name');
	}
}

function start(): void
{
	$linuxFactory = FactoryProducer::getFactory("Linux");

	$linuxFactory->createLabel()->getText();

	$windowsFactory = FactoryProducer::getFactory("Windows");

	$windowsFactory->createTextBox()->onValueChanged();

	$macosFactory = FactoryProducer::getFactory("MacOS");

	$macosFactory->createForm()->getPosition();
}

start();