class Array3D:
	def __init__(self, dim1: int, dim2: int, dim3: int):
		self.__dim1 = dim1
		self.__dim2 = dim2
		self.__dim3 = dim3
		self.__total_dimension = dim1 * dim2 * dim3
		self.__array = [None] * self.__total_dimension

	def __getitem__(self, index: tuple):
		if len(index) != 3 \
			or not isinstance(index[0], int) \
			or not isinstance(index[1], int) \
			or not isinstance(index[2], int):
			raise ValueError("Three indexes are needed")

		normal_index = self.__dim2 * self.__dim3 * index[0] + self.__dim3 * index[1] + index[2]

		if normal_index < 0 \
			or normal_index >= self.__total_dimension \
			or (index[0] < 0 or index[0] >= self.__dim1) \
			or (index[1] < 0 or index[1] >= self.__dim2) \
			or (index[2] < 0 or index[2] >= self.__dim3):
			raise IndexError('Index out of Array3D')

		return self.__array[normal_index]

	def getValues0(self, dim1: int):
		if dim1 < 0 or dim1 >= self.__dim1:
			raise IndexError('Index out of Array3D')

		array_to_return = []

		for i in range(self.__dim2 * dim1, self.__total_dimension, self.__dim1 * self.__dim2):
			array_to_return.append(self.__array[i: i + self.__dim2])

		return array_to_return

	def getValues1(self, dim2: int):
		if dim2 < 0 or dim2 >= self.__dim2:
			raise IndexError('Index out of Array3D')

		array_to_return = []
		temp_array = []

		for i in range(dim2, self.__total_dimension, self.__dim2):
			temp_array.append(self.__array[i])

			if len(temp_array) == self.__dim1:
				array_to_return.append(temp_array[:])
				temp_array = []

		return array_to_return

	def getValues2(self, dim3: int):
		if dim3 < 0 or dim3 >= self.__dim3:
			raise IndexError('Index out of Array3D')

		array_to_return = []

		temp_array = []
		for i in range(self.__dim1 * self.__dim2 * dim3, self.__dim1 * self.__dim2 * (dim3 + 1)):
			temp_array.append(self.__array[i])

			if len(temp_array) == self.__dim2:
				array_to_return.append(temp_array[:])
				temp_array = []

		return array_to_return

	def getValues01(self, dim1: int, dim2: int):
		if dim1 < 0 or dim1 >= self.__dim1\
			or dim2 < 0 or dim2 >= self.__dim2:
			raise IndexError('Index out of Array3D')

		return [self.__array[i] for i in range(dim1 * self.__dim2 + dim2, self.__total_dimension, self.__dim1 * self.__dim2)]

	def getValues02(self, dim1: int, dim3: int):
		if dim1 < 0 or dim1 >= self.__dim1\
			or dim3 < 0 or dim3 >= self.__dim3:
			raise IndexError('Index out of Array3D')

		return self.__array[self.__dim2 * dim1 + self.__dim1 * self.__dim2 * dim3: self.__dim2 * dim1 + self.__dim1 * self.__dim2 * dim3 + self.__dim2]

	def getValues12(self, dim2: int, dim3: int):
		if dim2 < 0 or dim2 >= self.__dim2\
			or dim3 < 0 or dim3 >= self.__dim3:
			raise IndexError('Index out of Array3D')

		return [self.__array[i] for i in range(dim2 + self.__dim1 * self.__dim2 * dim3, self.__dim1 * self.__dim2 + self.__dim1 * self.__dim2 * dim3, self.__dim2)]

	def setValues0(self, dim1: int, arr23: list):
		if dim1 < 0 or dim1 >= self.__dim1\
			or len(arr23) != self.__dim2 * self.__dim3:
			raise IndexError('Index out of Array3D')

		index = 0
		for i in range(self.__dim2 * dim1, self.__total_dimension, self.__dim1 * self.__dim2):
			for j in range(i, i + self.__dim2):
				self.__array[j] = arr23[index]
				index += 1

	def setValues1(self, dim2: int, arr13: list):
		if dim2 < 0 or dim2 >= self.__dim2\
			or len(arr13) != self.__dim1 * self.__dim3:
			raise IndexError('Index out of Array3D')

		index = 0
		for i in range(dim2, self.__total_dimension, self.__dim2):
			self.__array[i] = arr13[index]

			index += 1

	def setValues2(self, dim3: int, arr12: list):
		if dim3 < 0 or dim3 >= self.__dim3\
			or len(arr12) != self.__dim1 * self.__dim2:
			raise IndexError('Index out of Array3D')

		for i in range(self.__dim1 * self.__dim2 * dim3, self.__dim1 * self.__dim2 * (dim3 + 1)):
			self.__array[i] = arr12[i % (self.__dim1 * self.__dim2)]

	def setValues01(self, dim1: int, dim2: int, arr3: list):
		if dim1 < 0 or dim1 >= self.__dim1 \
			or dim2 < 0 or dim2 >= self.__dim2 \
			or len(arr3) != self.__dim3:
			raise IndexError('Index out of Array3D')

		index = 0
		for i in range(dim1 * self.__dim2 + dim2, self.__total_dimension, self.__dim1 * self.__dim2):
			self.__array[i] = arr3[index]
			index += 1

	def setValues02(self, dim1: int, dim3: int, arr2: list):
		if dim1 < 0 or dim1 >= self.__dim1 \
			or dim3 < 0 or dim3 >= self.__dim3 \
			or len(arr2) != self.__dim2:
			raise IndexError('Index out of Array3D')

		index = 0
		for i in range(self.__dim2 * dim1 + self.__dim1 * self.__dim2 * dim3, self.__dim2 * dim1 + self.__dim1 * self.__dim2 * dim3 + self.__dim2):
			self.__array[i] = arr2[index]
			index += 1

	def setValues12(self, dim2: int, dim3: int, arr1: list):
		if dim2 < 0 or dim2 >= self.__dim2 \
			or dim3 < 0 or dim3 >= self.__dim3 \
			or len(arr1) != self.__dim1:
			raise IndexError('Index out of Array3D')

		index = 0
		for i in range(dim2 + self.__dim1 * self.__dim2 * dim3, self.__dim1 * self.__dim2 + self.__dim1 * self.__dim2 * dim3, self.__dim2):
			self.__array[i] = arr1[index]
			index += 1

	def set_zero(self):
		self.__array = [0] * self.__total_dimension

	def set_ons(self):
		self.__array = [1] * self.__total_dimension

	def set_range(self):
		self.__array = [i for i in range(self.__total_dimension)]

	def set_num(self, num: int):
		self.__array = [num] * self.__total_dimension

	def get_array(self):
		return self.__array
