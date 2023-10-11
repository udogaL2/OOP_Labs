class Array3D:
	def __init__(self, dim1: int, dim2: int, dim3: int):
		self.my_array = [i for i in range(dim1 * dim2 * dim3)]
		self.dim1 = dim1
		self.dim2 = dim2
		self.dim3 = dim3
		self.total_dimension = dim1 * dim2 * dim3

	def __getitem__(self, index: tuple):
		if len(index) != 3 \
			or not isinstance(index[0], int) \
			or not isinstance(index[1], int) \
			or not isinstance(index[2], int):
			raise ValueError("Three indexes are needed")

		normal_index = self.dim2 * self.dim3 * index[0] + self.dim3 * index[1] + index[2]

		if normal_index < 0 \
			or normal_index >= self.total_dimension \
			or (index[0] < 0 or index[0] >= self.dim1) \
			or (index[1] < 0 or index[1] >= self.dim2) \
			or (index[2] < 0 or index[2] >= self.dim3):
			raise IndexError('Index out of Array3D')

		return self.my_array[normal_index]

	def getValues0(self, dim1: int):
		if dim1 < 0 or dim1 >= self.dim1:
			raise IndexError('Index out of Array3D')

		array_to_return = []

		for i in range(self.dim2 * dim1, self.total_dimension, self.dim1 * self.dim2):
			array_to_return.append(self.my_array[i: i + self.dim2])

		return array_to_return

	def getValues1(self, dim2: int):
		if dim2 < 0 or dim2 >= self.dim2:
			raise IndexError('Index out of Array3D')

		array_to_return = []
		temp_array = []

		for i in range(dim2, self.total_dimension, self.dim2):
			temp_array.append(self.my_array[i])

			if len(temp_array) == self.dim1:
				array_to_return.append(temp_array[:])
				temp_array = []

		return array_to_return

	def getValues2(self, dim3: int):
		if dim3 < 0 or dim3 >= self.dim3:
			raise IndexError('Index out of Array3D')

		array_to_return = []

		temp_array = []
		for i in range(self.dim1 * self.dim2 * dim3, self.dim1 * self.dim2 * (dim3 + 1)):
			temp_array.append(self.my_array[i])

			if len(temp_array) == self.dim2:
				array_to_return.append(temp_array[:])
				temp_array = []

		return array_to_return

	def getValues01(self, dim1: int, dim2: int):
		if dim1 < 0 or dim1 >= self.dim1\
			or dim2 < 0 or dim2 >= self.dim2:
			raise IndexError('Index out of Array3D')

		return [self.my_array[i] for i in range(dim1 * self.dim2 + dim2, self.total_dimension, self.dim1 * self.dim2)]

	def getValues02(self, dim1: int, dim3: int):
		if dim1 < 0 or dim1 >= self.dim1\
			or dim3 < 0 or dim3 >= self.dim3:
			raise IndexError('Index out of Array3D')

		return self.my_array[self.dim2 * dim1 + self.dim1 * self.dim2 * dim3: self.dim2 * dim1 + self.dim1 * self.dim2 * dim3 + self.dim2]

	def getValues12(self, dim2: int, dim3: int):
		if dim2 < 0 or dim2 >= self.dim2\
			or dim3 < 0 or dim3 >= self.dim3:
			raise IndexError('Index out of Array3D')

		return [self.my_array[i] for i in range(dim2 + self.dim1 * self.dim2 * dim3, self.dim1 * self.dim2 + self.dim1 * self.dim2 * dim3, self.dim2)]

	def setValues0(self, dim1: int, arr2: list, arr3: list):
		if dim1 < 0 or dim1 >= self.dim1\
			or len(arr2) != self.dim2\
			or len(arr3) != self.dim3:
			raise IndexError('Index out of Array3D')



a = Array3D(2, 3, 4)

print(a.getValues12(2, 1))
