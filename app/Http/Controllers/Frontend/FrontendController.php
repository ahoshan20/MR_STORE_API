<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Session\Store;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

class FrontendController extends Controller
{
    public function index()
    {
        return Inertia::render('Home',[
        'stats' => [
            'totalSales' => 15500,
            'orderCount' => 1000,
            'lowStockCount' => 10,
            'activeStaff' => 500,
        ],
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        ]);
    }
    public function barcode()
    {
        return Inertia::render('Barcode');
    }

    public function scan(Request $request)
{
    $barcode = $request->barcode;
    dd($barcode);

    $product = Product::where('barcode', $barcode)->first();

    if(!$product){
        return response()->json([
            'status' => 'not_found',
            'barcode' => $barcode
        ]);
    }

    return response()->json([
        'status' => 'found',
        'product' => $product
    ]);
}
}
