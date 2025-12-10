<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Category;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {

        $latestItems = Item::with('category')->latest()->take(5)->get();
        $latestCategories = Category::latest()->take(5)->get();


        $totalItems = Item::count();
        $totalCategories = Category::count();

        return view('dashboard', compact('latestItems', 'latestCategories', 'totalItems', 'totalCategories'));
    }
}
