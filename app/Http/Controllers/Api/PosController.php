<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class PosController extends Controller
{

    public function getAllProduct(){

        $product = Product::orderBy('id', 'DESC')->get();
        return Response::json($product, 200);

    }

    public function getAllCategory(){

        $category = Category::orderBy('id', 'DESC')->get();
        return Response::json($category, 200);

    }

    public function getProductCategoryById($id){

        $product = Product::where('category_id', $id)->orderBy('id', 'DESC')->get();
        return Response::json($product);

    }

}
