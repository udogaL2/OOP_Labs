from math import lcm, gcd


class Fraction:
	def __init__(self, numerator: int, denominator: int):
		if (
			not (numerator >= 0)
			or not (denominator > 0)
		):
			raise Exception("Переданные данные не могут быть отрицательными или равны нулю")

		self.__numerator = numerator
		self.__denominator = denominator
		self.__sing = False

		self.__to_normal_appearance()

	def __to_normal_appearance(self):
		current_gcd = gcd(self.__numerator, self.__denominator)

		self.__numerator = self.__numerator // current_gcd
		self.__denominator = self.__denominator // current_gcd

	def __add__(self, other):
		current_lcm = lcm(self.__denominator, other.__denominator)

		new_numerator = (-1 if self.__sing else 1) * self.__numerator * (current_lcm // self.__denominator) \
			+ (-1 if other.__sing else 1) * other.__numerator * (current_lcm // other.__denominator)

		new_fraction = Fraction(abs(new_numerator), current_lcm)
		new_fraction.__set_sing(new_numerator < 0)
		new_fraction.__to_normal_appearance()

		return new_fraction

	def __sub__(self, other):
		current_lcm = lcm(self.__denominator, other.__denominator)

		new_numerator = (-1 if self.__sing else 1) * self.__numerator * (current_lcm // self.__denominator) \
			- (-1 if other.__sing else 1) * other.__numerator * (current_lcm // other.__denominator)

		new_fraction = Fraction(abs(new_numerator), current_lcm)
		new_fraction.__set_sing(new_numerator < 0)
		new_fraction.__to_normal_appearance()

		return new_fraction

	def __mul__(self, other):
		new_fraction = Fraction(self.__numerator * other.__numerator, self.__denominator * other.__denominator)
		new_fraction.__set_sing(self.__sing ^ other.__sing)
		new_fraction.__to_normal_appearance()

		return new_fraction

	def __truediv__(self, other):
		new_fraction = Fraction(self.__numerator * other.__denominator, self.__denominator * other.__numerator)
		new_fraction.__set_sing(self.__sing ^ other.__sing)
		new_fraction.__to_normal_appearance()

		return new_fraction

	def to_decimal(self):
		return self.__numerator / self.__denominator

	def __str__(self):
		if self.__numerator == self.__denominator:
			return '-1' if self.__sing else '1'

		elif self.__numerator == 0:
			return '0'

		return '-' * self.__sing + str(self.__numerator) + '/' + str(self.__denominator)

	def __set_sing(self, sing: bool):
		self.__sing = sing


class Calculator:
	def __init__(self):
		self.__self_fraction = self.__get_fraction()

	def start(self):
		running = True
		while running:
			print(
				'Введите номер команды:\n'
				+ '1. сложить две дроби\n'
				+ '2. вычесть из текущей другую\n'
				+ '3. перемножить две дроби\n'
				+ '4. разделить текущую дробь на другую\n'
				+ '5. перевести в десятичную\n\n'
				+ '0. выйти\n'
			)
			command = input()

			if command == '0':
				running = False

			elif command == '1':
				second_fraction = self.__get_fraction()
				self.__self_fraction = self.__self_fraction + second_fraction

			elif command == '2':
				second_fraction = self.__get_fraction()
				self.__self_fraction = self.__self_fraction - second_fraction

			elif command == '3':
				second_fraction = self.__get_fraction()
				self.__self_fraction = self.__self_fraction * second_fraction

			elif command == '4':
				second_fraction = self.__get_fraction()
				self.__self_fraction = self.__self_fraction / second_fraction

			elif command == '5':
				print('Десятичный вид дроби:', self.__self_fraction.to_decimal())

			else:
				print('Неверная команда')
				continue

			print('Текущий результат:', self.__self_fraction)

	def __get_fraction(self):
		print('Введите дробь в формате числитель/знаменатель (e.g. 1/2)')

		raw_fraction = input()
		if '/' not in raw_fraction:
			raise Exception('Ошибка ввода дроби, отсутствует /')

		fraction = raw_fraction.strip().split('/')

		if (
			not fraction[0].isdigit()
			or not fraction[1].isdigit()
		):
			raise Exception('Ошибка ввода дроби, введены ненатуральные числа')

		return Fraction(int(fraction[0]), int(fraction[1]))


if __name__ == '__main__':
	calculator = Calculator()

	calculator.start()
