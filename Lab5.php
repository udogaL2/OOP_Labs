<?php

class User
{
	private int $id;
	private string $name;
	private string $login;
	private string $password;

	public function __construct(int $id, string $name, string $login, string $password)
	{
		$this->id = $id;
		$this->name = $name;
		$this->login = $login;
		$this->password = $password;
	}

	public function getId(): int
	{
		return $this->id;
	}

	public function getName(): string
	{
		return $this->name;
	}

	public function setName(string $name): void
	{
		$this->name = $name;
	}

	public function getLogin(): string
	{
		return $this->login;
	}

	public function setLogin(string $login): void
	{
		$this->login = $login;
	}

	public function getPassword(): string
	{
		return $this->password;
	}

	public function setPassword(string $password): void
	{
		$this->password = $password;
	}
}

interface UserManagerInterface
{
	public static function signIn(User $user): bool;

	public static function singUp(User $user): bool;

	public static function signOut(): bool;

	public static function isAuthorized(): bool;
}

interface DataRepositoryInterface
{
	public static function get(): array;

	public static function add(User $item): bool;

	public static function remove(User $item): bool;

	public static function update(User $item): bool;
}

interface UserRepositoryInterface
{
	public function getById(int $id): User;

	public function getByName(string $name): User;
}

class DataRepository implements DataRepositoryInterface
{
	private static string $DIRECTORY = __DIR__  . '/data/';
	private static array $repository;

	public static function get(): array
	{
		$files =  array_diff(scandir(self::$DIRECTORY), array('..', '.'));

		foreach ($files as $file)
		{
			if (str_contains($file, '.txt'))
			{
				$handle = file_get_contents(self::$DIRECTORY . $file);

				$data = unserialize($handle, ['allowed_classes' => ['User']]);

				if ($data)
				{
					self::$repository[] = $data;
				}
			}
		}

		return self::$repository;
	}

	public static function add(User $item): bool
	{
		$file = self::$DIRECTORY . $item->getName();

		if (file_exists($file))
		{
			return false;
		}

		if(!file_put_contents($file, serialize($file)))
		{
			return false;
		}


		self::$repository[$item->getName()] = $item;

		return true;
	}

	public static function remove(User $item): bool
	{
		$file = self::$DIRECTORY . $item->getName();

		if (!file_exists($file))
		{
			return false;
		}

		if (!unlink($file))
		{
			return false;
		}

		unset(self::$repository[$item->getName()]);

		return true;
	}

	public static function update(User $item): bool
	{
		return $this->remove($item) && $this->add($item);
	}
}

class UserManagerBase implements UserManagerInterface
{
	public static function signIn(User $user): bool
	{

		return true;
	}

	public static function signOut(): bool
	{
		// TODO: Implement signOut() method.
		return true;
	}

	public static function isAuthorized(): bool
	{
		// TODO: Implement isAuthorized() method.
		return true;
	}

	public static function singUp(User $user): bool
	{
		return DataRepository::add($user);
	}
}

