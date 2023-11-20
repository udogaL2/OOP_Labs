<?php

class User
{
	private string $name;
	private string $login;
	private string $password;

	public function __construct(string $name, string $login, string $password)
	{
		$this->name = $name;
		$this->login = $login;
		$this->password = $password;
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
	public static function signIn(string $login, string $password): bool;

	public static function singUp(User $user): bool;

	public static function signOut(): bool;

	public static function isAuthorized(): bool;
}

interface DataRepositoryInterface
{
	public function get(): array;

	public function add(User $user): bool;

	public function remove(User $user): bool;

	public function update(User $user): bool;
}

interface UserRepositoryInterface extends DataRepositoryInterface
{
	public function getById(int $id): ?User;

	public function getByName(string $name): ?User;
}

class DataRepository implements DataRepositoryInterface
{
	protected string $DIRECTORY = __DIR__  . '\\data\\';
	protected array $repository = [];

	public function get(): array
	{
		$this->checkDirection();

		$files =  array_diff(scandir($this->DIRECTORY), array('..', '.'));

		foreach ($files as $file)
		{
			if (str_contains($file, '.txt'))
			{
				$handle = file_get_contents($this->DIRECTORY . $file);

				/* @var User $data */
				$data = unserialize($handle, ['allowed_classes' => ['User']]);

				if ($data && empty($this->repository[$data->getLogin()]))
				{
					$this->repository[$data->getLogin()] = $data;
				}
			}
		}

		return $this->repository;
	}

	public function add(User $user): bool
	{
		$this->checkDirection();

		$file = $this->DIRECTORY . $user->getLogin() . '.txt';

		if (file_exists($file))
		{
			return false;
		}

		if(!file_put_contents($file, serialize($user)))
		{
			return false;
		}


		$this->repository[$user->getLogin()] = $user;

		return true;
	}

	public function remove(User $user): bool
	{
		$this->checkDirection();

		$file = $this->DIRECTORY . $user->getLogin() . '.txt';

		if (!file_exists($file))
		{
			return false;
		}

		if (!unlink($file))
		{
			return false;
		}

		unset($this->repository[$user->getLogin()]);

		return true;
	}

	public function update(User $user): bool
	{
		return $this->remove($user) && $this->add($user);
	}

	protected function checkDirection(): void
	{
		if (!file_exists($this->DIRECTORY))
		{
			mkdir($this->DIRECTORY);
		}
	}
}

class UserRepository extends DataRepository implements UserRepositoryInterface
{
	protected string $DIRECTORY = __DIR__  . '\\cookie\\';
	protected array $repository = [];

	public function getById(int $id): ?User
	{
		return $this->repository[$id] ?? null;
	}

	public function getByName(string $name): ?User
	{
		/* @var User $user*/
		foreach ($this->repository as $user)
		{
			if ($user->getName() === $name)
			{
				return $user;
			}
		}

		return null;
	}
}

class UserManager implements UserManagerInterface
{
	public static ?User $currentUser = null;

	public static function signIn(string $login, ?string $password = null): bool
	{
		$data = DataManager::getDataRepository()->get();

		if (empty($data[$login]))
		{
			return false;
		}

		/* @var User $user*/
		$user = $data[$login];

		if (isset(DataManager::getUserRepository()->get()[$login]))
		{
			self::$currentUser = $data[$login];

			return true;
		}

		if ($user->getPassword() !== $password)
		{
			return false;
		}

		self::$currentUser = $data[$login];

		return DataManager::getUserRepository()->add(self::$currentUser);
	}

	public static function signOut(): bool
	{
		if (!self::isAuthorized())
		{
			return false;
		}

		$result = DataManager::getUserRepository()->remove(self::$currentUser);
		self::$currentUser = null;

		return $result;
	}

	public static function isAuthorized(): bool
	{
		return self::$currentUser !== null;
	}

	public static function singUp(User $user): bool
	{
		$data = DataManager::getDataRepository()->get();

		if (isset($data[$user->getLogin()]))
		{
			return false;
		}

		return DataManager::getDataRepository()->add($user);
	}
}

class DataManager
{
	private static ?DataRepository $dataRepository;
	private static ?UserRepository $userRepository;

	public static function getUserRepository(): UserRepository
	{
		if (empty(self::$userRepository))
		{
			self::$userRepository = new UserRepository();
		}

		return self::$userRepository;
	}

	public static function getDataRepository(): DataRepository
	{
		if (empty(self::$dataRepository))
		{
			self::$dataRepository = new DataRepository();
		}

		return self::$dataRepository;
	}
}

function test1(): void
{
	var_dump(UserManager::singUp(new User('BOB', 'BOB11', 'qwerty')));
}

function test2(): void
{
	var_dump(UserManager::signIn('BOB11', 'qwerty'));
}

function test3(): void
{
	var_dump(UserManager::signIn('BOB11'));
}

function test4(): void
{
	var_dump(UserManager::signIn('BOB11'));
	var_dump(UserManager::signOut());
	var_dump(UserManager::signIn('BOB11'));
}

test4();
