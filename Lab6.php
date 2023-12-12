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
		echo "������ ����� setPosition � ��������� WindowsForm\n";
	}

	function getPosition(): array
	{
		echo "������ ����� getPosition � ��������� WindowsForm\n";

		return [];
	}

	function addControl(Control $control): void
	{
		echo "������ ����� addControl � ��������� WindowsForm\n";
	}
}

class WindowsLabel implements Label
{
	function setPosition(array $position): void
	{
		echo "������ ����� setPosition � ��������� WindowsLabel\n";
	}

	function getPosition(): array
	{
		echo "������ ����� getPosition � ��������� WindowsLabel\n";

		return [];
	}

	function setText(string $text): void
	{
		echo "������ ����� setText � ��������� WindowsLabel\n";
	}

	function getText(): string
	{
		echo "������ ����� getText � ��������� WindowsLabel\n";

		return '';
	}
}

class WindowsTextBox implements TextBox
{
	function setPosition(array $position): void
	{
		echo "������ ����� setPosition � ��������� WindowsTextBox\n";
	}

	function getPosition(): array
	{
		echo "������ ����� getPosition � ��������� WindowsTextBox\n";

		return [];
	}

	function setText(string $text): void
	{
		echo "������ ����� setText � ��������� WindowsTextBox\n";
	}

	function getText(): string
	{
		echo "������ ����� getText � ��������� WindowsTextBox\n";

		return '';
	}

	function onValueChanged(): void
	{
		echo "������ ����� onValueChanged � ��������� WindowsTextBox\n";
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
		echo "������ ����� setPosition � ��������� LinuxForm\n";
	}

	function getPosition(): array
	{
		echo "������ ����� getPosition � ��������� LinuxForm\n";

		return [];
	}

	function addControl(Control $control): void
	{
		echo "������ ����� addControl � ��������� LinuxForm\n";
	}
}

class LinuxLabel implements Label
{

	function setPosition(array $position): void
	{
		echo "������ ����� setPosition � ��������� LinuxLabel\n";
	}

	function getPosition(): array
	{
		echo "������ ����� getPosition � ��������� LinuxLabel\n";

		return [];
	}

	function setText(string $text): void
	{
		echo "������ ����� setText � ��������� LinuxLabel\n";
	}

	function getText(): string
	{
		echo "������ ����� getText � ��������� LinuxLabel\n";

		return '';
	}
}

class LinuxTextBox implements TextBox
{
	function setPosition(array $position): void
	{
		echo "������ ����� setPosition � ��������� LinuxTextBox\n";
	}

	function getPosition(): array
	{
		echo "������ ����� getPosition � ��������� LinuxTextBox\n";

		return [];
	}

	function setText(string $text): void
	{
		echo "������ ����� setText � ��������� LinuxTextBox\n";
	}

	function getText(): string
	{
		echo "������ ����� getText � ��������� LinuxTextBox\n";

		return '';
	}

	function onValueChanged(): void
	{
		echo "������ ����� onValueChanged � ��������� LinuxTextBox\n";
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
		echo "������ ����� setPosition � ��������� MacosForm\n";
	}

	function getPosition(): array
	{
		echo "������ ����� getPosition � ��������� MacosForm\n";

		return [];
	}

	function addControl(Control $control): void
	{
		echo "������ ����� addControl � ��������� MacosForm\n";
	}
}

class MacosLabel implements Label
{

	function setPosition(array $position): void
	{
		echo "������ ����� setPosition � ��������� MacosForm\n";
	}

	function getPosition(): array
	{
		echo "������ ����� getPosition � ��������� MacosForm\n";

		return [];
	}

	function setText(string $text): void
	{
		echo "������ ����� setText � ��������� MacosForm\n";
	}

	function getText(): string
	{
		echo "������ ����� getText � ��������� MacosForm\n";

		return '';
	}
}

class MacosTextBox implements TextBox
{
	function setPosition(array $position): void
	{
		echo "������ ����� setPosition � ��������� MacosForm\n";
	}

	function getPosition(): array
	{
		echo "������ ����� getPosition � ��������� MacosForm\n";

		return [];
	}

	function setText(string $text): void
	{
		echo "������ ����� setText � ��������� MacosForm\n";
	}

	function getText(): string
	{
		echo "������ ����� getText � ��������� MacosForm\n";

		return '';
	}

	function onValueChanged(): void
	{
		echo "������ ����� onValueChanged � ��������� MacosForm\n";
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