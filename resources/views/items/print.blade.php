<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Data Barang</title>
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        /* CSS Khusus Cetak */
        @media print {
            .no-print {
                display: none;
            }

            body {
                -webkit-print-color-adjust: exact;
            }
        }
    </style>
</head>

<body class="bg-white p-8">

    <div class="text-center mb-8 border-b-2 border-gray-800 pb-4">
        <h1 class="text-3xl font-bold uppercase tracking-wider">Laporan Inventaris Barang</h1>
        <p class="text-gray-600 mt-1">Dicetak pada: {{ date('d F Y, H:i') }}</p>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full border-collapse border border-gray-400">
            <thead>
                <tr class="bg-gray-200">
                    <th class="border border-gray-400 px-4 py-2 text-left text-sm font-bold text-gray-700">No</th>
                    <th class="border border-gray-400 px-4 py-2 text-left text-sm font-bold text-gray-700">Nama Barang
                    </th>
                    <th class="border border-gray-400 px-4 py-2 text-left text-sm font-bold text-gray-700">Kategori</th>
                    <th class="border border-gray-400 px-4 py-2 text-center text-sm font-bold text-gray-700">Jumlah</th>
                    <th class="border border-gray-400 px-4 py-2 text-right text-sm font-bold text-gray-700">Harga Satuan
                    </th>
                    <th class="border border-gray-400 px-4 py-2 text-right text-sm font-bold text-gray-700">Total Aset
                    </th>
                </tr>
            </thead>
            <tbody>
                @php $totalAset = 0; @endphp
                @foreach ($items as $index => $item)
                    @php
                        $subtotal = $item->quantity * $item->price;
                        $totalAset += $subtotal;
                    @endphp
                    <tr class="hover:bg-gray-50">
                        <td class="border border-gray-400 px-4 py-2 text-center">{{ $index + 1 }}</td>
                        <td class="border border-gray-400 px-4 py-2">{{ $item->name }}</td>
                        <td class="border border-gray-400 px-4 py-2">{{ $item->category->name ?? '-' }}</td>
                        <td class="border border-gray-400 px-4 py-2 text-center">{{ $item->quantity }}</td>
                        <td class="border border-gray-400 px-4 py-2 text-right">Rp
                            {{ number_format($item->price, 0, ',', '.') }}</td>
                        <td class="border border-gray-400 px-4 py-2 text-right">Rp
                            {{ number_format($subtotal, 0, ',', '.') }}</td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr class="bg-gray-100 font-bold">
                    <td colspan="5" class="border border-gray-400 px-4 py-2 text-right">TOTAL NILAI ASET</td>
                    <td class="border border-gray-400 px-4 py-2 text-right">Rp
                        {{ number_format($totalAset, 0, ',', '.') }}</td>
                </tr>
            </tfoot>
        </table>
    </div>

    <div class="mt-12 flex justify-end">
        <div class="text-center w-64">
            <p class="mb-20">Mengetahui,</p>
            <p class="font-bold underline">{{ Auth::user()->name }}</p>
            <p>Admin Inventaris</p>
        </div>
    </div>

    <div class="fixed bottom-4 right-4 print:hidden flex gap-2">
        <button onclick="window.print()"
            class="bg-blue-600 text-white px-6 py-3 rounded-full shadow-lg hover:bg-blue-700 font-bold">
            Cetak / Simpan PDF
        </button>
        <button onclick="window.history.back()"
            class="bg-gray-500 text-white px-6 py-3 rounded-full shadow-lg hover:bg-gray-600 font-bold">
            Kembali
        </button>
    </div>

    <script>
        window.onload = function() {
            window.print();
        }
    </script>

</body>

</html>
