<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Data Barang</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* CSS khusus saat dicetak */
        @media print {
            .no-print {
                display: none;
            }
        }
    </style>
</head>

<body class="bg-white p-10">

    <div class="text-center mb-8 border-b-2 border-gray-800 pb-4">
        <h1 class="text-3xl font-bold uppercase">Laporan Inventaris Barang</h1>
        <p class="text-gray-600">Dicetak pada: {{ now()->format('d M Y H:i') }}</p>
        <p class="text-gray-600">Oleh: {{ Auth::user()->name }}</p>
    </div>

    <table class="w-full border-collapse border border-gray-400">
        <thead>
            <tr class="bg-gray-200">
                <th class="border border-gray-400 px-4 py-2 text-left">No</th>
                <th class="border border-gray-400 px-4 py-2 text-left">Nama Barang</th>
                <th class="border border-gray-400 px-4 py-2 text-left">Kategori</th>
                <th class="border border-gray-400 px-4 py-2 text-center">Jumlah</th>
                <th class="border border-gray-400 px-4 py-2 text-right">Harga</th>
                <th class="border border-gray-400 px-4 py-2 text-right">Total Aset</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($items as $index => $item)
                <tr>
                    <td class="border border-gray-400 px-4 py-2 text-center">{{ $index + 1 }}</td>
                    <td class="border border-gray-400 px-4 py-2">{{ $item->name }}</td>
                    <td class="border border-gray-400 px-4 py-2">{{ $item->category->name ?? '-' }}</td>
                    <td class="border border-gray-400 px-4 py-2 text-center">{{ $item->quantity }}</td>
                    <td class="border border-gray-400 px-4 py-2 text-right">
                        Rp {{ number_format($item->price, 0, ',', '.') }}
                    </td>
                    <td class="border border-gray-400 px-4 py-2 text-right font-bold">
                        Rp {{ number_format($item->quantity * $item->price, 0, ',', '.') }}
                    </td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr class="bg-gray-100 font-bold">
                <td colspan="5" class="border border-gray-400 px-4 py-2 text-right">TOTAL NILAI ASET:</td>
                <td class="border border-gray-400 px-4 py-2 text-right">
                    Rp {{ number_format($items->sum(fn($i) => $i->quantity * $i->price), 0, ',', '.') }}
                </td>
            </tr>
        </tfoot>
    </table>

    <div class="mt-10 flex justify-end">
        <div class="text-center mr-10">
            <p class="mb-20">Mengetahui, <br> Admin Inventaris</p>
            <p class="font-bold underline">{{ Auth::user()->name }}</p>
        </div>
    </div>

    <script>
        window.onload = function() {
            window.print();
        }
    </script>

    <div class="no-print fixed top-5 right-5">
        <a href="{{ route('items.index') }}"
            class="bg-gray-500 text-white px-4 py-2 rounded shadow hover:bg-gray-700">Kembali</a>
    </div>

</body>

</html>
