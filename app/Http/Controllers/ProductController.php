<?php

namespace App\Http\Controllers;

use App\Models\Content;
use Illuminate\Http\Request;
use App\Models\Product;
use PhpParser\Node\Expr\Cast\Double;

class ProductController extends Controller
{
    public function get_all_products() {
        $product = Product::all();
        return response()->json([
            'products' => $product
        ],200);
    }

    
}