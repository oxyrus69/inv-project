<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\Item;
use Illuminate\Support\Facades\DB;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index(Request $request)
    {
        $query = Item::with('category');

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;


            $isPgsql = DB::connection()->getDriverName() === 'pgsql';


            $operator = $isPgsql ? 'ilike' : 'like';

            $query->where(function ($q) use ($search, $operator, $isPgsql) {

                $q->where('name', $operator, '%' . $search . '%')


                    ->orWhereHas('category', function ($subQuery) use ($search, $operator) {
                        $subQuery->where('name', $operator, '%' . $search . '%');
                    });


                if ($isPgsql) {
                    $q->orWhereRaw("CAST(quantity AS TEXT) $operator ?", ['%' . $search . '%'])
                        ->orWhereRaw("CAST(price AS TEXT) $operator ?", ['%' . $search . '%']);
                } else {

                    $q->orWhere('quantity', $operator, '%' . $search . '%')
                        ->orWhere('price', $operator, '%' . $search . '%');
                }
            });
        }


        $items = $query->latest()->paginate(10);

        return view('items.index', compact('items'));
    }

    /**
     * Show the form for creating a new resource.
     */
    // Menampilkan form tambah
    public function create()
    {
        $categories = Category::all();
        return view('items.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    // Menyimpan data baru
    public function store(Request $request)
    {
        // 1. Validasi dihidupkan kembali (Pastikan EJAANNYA persis ini)
        $request->validate([
            'name' => 'required|string|max:255',
            // Kuncinya di sini: pastikan 'category_id' tertulis benar tanpa spasi
            'category_id' => 'required|exists:categories,id',
            'quantity' => 'required|integer|min:0',
            'price' => 'required|numeric|min:0',
        ]);

        // 2. Simpan Data
        Item::create($request->all());

        // 3. Redirect Sukses
        return redirect()->route('items.index')
            ->with('success', 'Barang berhasil ditambahkan.');
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Item $item)
    {
        $categories = Category::all();
        return view('items.edit', compact('item', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    // Update data
    public function update(Request $request, Item $item)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'quantity' => 'required|integer|min:0',
            'price' => 'required|numeric|min:0',
        ]);

        $item->update($request->all());

        return redirect()->route('items.index')
            ->with('success', 'Barang berhasil diperbarui.');
    }

    public function print()
    {
        $items = \App\Models\Item::with('category')->get();

        return view('items.print', compact('items'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Item $item)
    {
        $item->delete();

        return redirect()->route('items.index')
            ->with('success', 'Barang berhasil dihapus.');
    }
}
