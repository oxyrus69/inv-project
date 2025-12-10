<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-4 border-blue-500">
                    <div class="text-gray-500 text-sm font-medium">Total Barang</div>
                    <div class="text-3xl font-bold text-gray-800">{{ $totalItems }}</div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-4 border-green-500">
                    <div class="text-gray-500 text-sm font-medium">Total Kategori</div>
                    <div class="text-3xl font-bold text-gray-800">{{ $totalCategories }}</div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-lg font-bold text-gray-800">5 Barang Terbaru</h3>
                            <a href="{{ route('items.index') }}" class="text-sm text-blue-500 hover:underline">Lihat
                                Semua &rarr;</a>
                        </div>

                        <div class="overflow-x-auto">
                            <table class="w-full text-sm text-left text-gray-500">
                                <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                                    <tr>
                                        <th class="px-4 py-2">Nama</th>
                                        <th class="px-4 py-2">Kategori</th>
                                        <th class="px-4 py-2">Harga</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($latestItems as $item)
                                        <tr class="border-b">
                                            <td class="px-4 py-2 font-medium text-gray-900">{{ $item->name }}</td>
                                            <td class="px-4 py-2 text-xs">
                                                <span
                                                    class="bg-blue-100 text-blue-800 text-xs font-semibold mr-2 px-2.5 py-0.5 rounded">
                                                    {{ $item->category->name ?? '-' }}
                                                </span>
                                            </td>
                                            <td class="px-4 py-2">Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3" class="px-4 py-2 text-center text-gray-400">Belum ada
                                                data barang.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-lg font-bold text-gray-800">5 Kategori Terbaru</h3>
                            <a href="{{ route('categories.index') }}"
                                class="text-sm text-blue-500 hover:underline">Lihat Semua &rarr;</a>
                        </div>

                        <div class="overflow-x-auto">
                            <table class="w-full text-sm text-left text-gray-500">
                                <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                                    <tr>
                                        <th class="px-4 py-2">Nama Kategori</th>
                                        <th class="px-4 py-2">Tanggal Dibuat</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($latestCategories as $cat)
                                        <tr class="border-b">
                                            <td class="px-4 py-2 font-medium text-gray-900">{{ $cat->name }}</td>
                                            <td class="px-4 py-2 text-xs text-gray-400">
                                                {{ $cat->created_at->format('d M Y') }}
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="2" class="px-4 py-2 text-center text-gray-400">Belum ada
                                                kategori.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>
</x-app-layout>
