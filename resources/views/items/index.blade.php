<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Daftar Inventaris') }}
        </h2>
    </x-slot>

    <div class="py-12" x-data="{ showDeleteModal: false, deleteAction: '' }">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                <div class="flex flex-col md:flex-row justify-between mb-4 gap-4">
                    <div class="flex gap-2 w-full md:w-auto">
                        <a href="{{ route('items.create') }}"
                            class="text-center bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded w-full md:w-auto">
                            + Tambah Barang
                        </a>

                        <a href="{{ route('items.print') }}" target="_blank"
                            class="text-center bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded w-full md:w-auto flex items-center justify-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z">
                                </path>
                            </svg>
                            Cetak Laporan
                        </a>
                    </div>
                    <form method="GET" action="{{ route('items.index') }}" class="flex w-full md:w-auto">
                        <input type="text" name="search" placeholder="Cari barang..."
                            class="border rounded-l py-2 px-4 w-full" value="{{ request('search') }}">
                        <button type="submit"
                            class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded-r">Cari</button>
                    </form>
                </div>

                @if (session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="overflow-x-auto relative shadow-md sm:rounded-lg">
                    <table class="w-full text-sm text-left text-gray-500">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-100">
                            <tr>
                                <th scope="col" class="px-6 py-3 whitespace-nowrap">Nama Barang</th>
                                <th scope="col" class="px-6 py-3 whitespace-nowrap">Kategori</th>
                                <th scope="col" class="px-6 py-3 whitespace-nowrap">Jumlah</th>
                                <th scope="col" class="px-6 py-3 whitespace-nowrap">Harga</th>
                                <th scope="col" class="px-6 py-3 whitespace-nowrap">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($items as $index => $item)
                                <tr class="hover:bg-gray-100 border-b">
                                    <td class="py-2 px-4 border-b text-center">{{ $index + $items->firstItem() }}</td>
                                    <td class="py-2 px-4 border-b">{{ $item->name }}</td>
                                    <td class="py-2 px-4 border-b">{{ $item->category->name ?? '-' }}</td>
                                    <td class="py-2 px-4 border-b text-center">{{ $item->quantity }}</td>
                                    <td class="py-2 px-4 border-b">Rp {{ number_format($item->price, 0, ',', '.') }}
                                    </td>
                                    <td class="py-2 px-4 border-b text-center">
                                        <a href="{{ route('items.edit', $item->id) }}"
                                            class="text-blue-500 hover:text-blue-700 mx-1">Edit</a>
                                        <form action="{{ route('items.destroy', $item->id) }}" method="POST"
                                            class="inline" onsubmit="return confirm('Yakin ingin menghapus?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="text-red-500 hover:text-red-700 mx-1">Hapus</button>
                                        </form>
                                    </td>
                                </tr>


                            @empty
                                <tr>

                                    <td colspan="6" class="py-8 text-center text-gray-500">
                                        <div class="flex flex-col items-center justify-center">
                                            <p class="text-lg font-semibold">Data tidak ditemukan.</p>
                                            <p class="text-sm">Coba kata kunci lain atau tambahkan barang baru.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">
                    {{ $items->links() }}
                </div>
            </div>
        </div>

        <div x-show="showDeleteModal" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
            <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 transition-opacity" aria-hidden="true" @click="showDeleteModal = false">
                    <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
                </div>

                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                <div
                    class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start">
                            <div
                                class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                                <svg class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                </svg>
                            </div>
                            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                <h3 class="text-lg leading-6 font-medium text-gray-900">Hapus Data Barang</h3>
                                <div class="mt-2">
                                    <p class="text-sm text-gray-500">Apakah Anda yakin ingin menghapus data ini? Data
                                        yang dihapus tidak dapat dikembalikan.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">

                        <form :action="deleteAction" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none sm:ml-3 sm:w-auto sm:text-sm">
                                Ya, Hapus
                            </button>
                        </form>

                        <button @click="showDeleteModal = false" type="button"
                            class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                            Batal
                        </button>
                    </div>
                </div>
            </div>
        </div>

    </div>
</x-app-layout>
