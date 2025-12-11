<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Edit Barang</h2>
    </x-slot>

    <div class="py-12" x-data="{
        showModal: false,
        form: {
    
            name: '{{ old('name', $item->name) }}',
            category_id: '{{ old('category_id', $item->category_id) }}',
            quantity: '{{ old('quantity', $item->quantity) }}',
            price: '{{ old('price', $item->price) }}'
        }
    }">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">


                <form x-ref="formItem" action="{{ route('items.update', $item->id) }}" method="POST"
                    @submit.prevent="showModal = true">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Nama Barang</label>
                        <input type="text" name="name" x-model="form.name"
                            class="shadow border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                            required>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Kategori</label>

                        <select name="category_id" x-model="form.category_id"
                            class="shadow border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                            required>
                            <option value="" disabled>-- Pilih Kategori --</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Jumlah</label>
                            <input type="number" name="quantity" x-model="form.quantity"
                                class="shadow border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                required>
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Harga Satuan (Rp)</label>
                            <input type="number" name="price" x-model="form.price"
                                class="shadow border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                required>
                        </div>
                    </div>

                    <div class="flex items-center justify-between mt-4">
                        <button type="submit"
                            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline transition duration-150 ease-in-out">
                            Perbaharui Data
                        </button>
                        <a href="{{ route('items.index') }}"
                            class="text-gray-500 hover:text-gray-800 font-bold">Batal</a>
                    </div>
                </form>

            </div>
        </div>


        <div x-show="showModal" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
            <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 transition-opacity" aria-hidden="true" @click="showModal = false">
                    <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
                </div>
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                <div
                    class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start">
                            <div
                                class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-blue-100 sm:mx-0 sm:h-10 sm:w-10">
                                <svg class="h-6 w-6 text-blue-600" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                                <h3 class="text-lg leading-6 font-medium text-gray-900">Konfirmasi Update</h3>
                                <div class="mt-2">
                                    <p class="text-sm text-gray-500">Yakin ingin mengubah data ini?</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <button @click="$refs.formItem.submit()" type="button"
                            class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none sm:ml-3 sm:w-auto sm:text-sm">
                            Ya, Update
                        </button>
                        <button @click="showModal = false" type="button"
                            class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                            Cek Lagi
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
