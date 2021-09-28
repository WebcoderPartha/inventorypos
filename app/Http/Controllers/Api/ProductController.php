<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Intervention\Image\Facades\Image;
use League\CommonMark\Extension\CommonMark\Renderer\Inline\EmphasisRenderer;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::with(['category', 'supplier'])->orderBy('id', 'DESC',)->get();
        return Response::json($products);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validateData = $request->validate([
            'category_id'   => 'required',
            'product_name'  => 'required|unique:products',
            'product_code'  => 'required|unique:products',
            'root'          => '',
            'buying_price'  => '',
            'selling_price' => 'required',
            'supplier_id'   => '',
            'buying_date'   => '',
            'quantity'      => 'required',
        ]);

        if ($request->image){

            $position   = strpos($request->image, ';');
            $sub        = substr($request->image, 0, $position);
            $extension  = explode('/', $sub)[1];
            $imageName  = time().'.'.$extension;
            $location   = 'backend/product/';
            $image      = $location.$imageName;

            Image::make($request->image)->resize(640, 640)->save(public_path($image));

            $product                = new Product();
            $product->category_id   = $request->category_id;
            $product->product_name  = $request->product_name;
            $product->product_code  = $request->product_code;
            $product->root          = $request->root;
            $product->buying_price  = $request->buying_price;
            $product->selling_price = $request->selling_price;
            $product->supplier_id   = $request->supplier_id;
            $product->buying_date   = $request->buying_date;
            $product->quantity      = $request->quantity;
            $product->image         = $image;
            $product->save();

            return Response::json('Product stored successfully');

        }else{

            $product                = new Product();
            $product->category_id   = $request->category_id;
            $product->product_name  = $request->product_name;
            $product->product_code  = $request->product_code;
            $product->root          = $request->root;
            $product->buying_price  = $request->buying_price;
            $product->selling_price = $request->selling_price;
            $product->supplier_id   = $request->supplier_id;
            $product->buying_date   = $request->buying_date;
            $product->quantity      = $request->quantity;
            $product->save();
            return Response::json('Product stored successfully without image');

        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = Product::with(['category', 'supplier'])->where('id', $id)->first();

        return Response::json($product);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $validateData = $request->validate([
            'category_id'   => 'required',
            'product_name'  => 'required|unique:products,product_name,'.$id,
            'product_code'  => 'required|unique:products,product_code,'.$id,
            'root'          => '',
            'buying_price'  => '',
            'selling_price' => 'required',
            'supplier_id'   => '',
            'buying_date'   => '',
            'quantity'      => 'required',
        ]);

        if ($request->newimage){

            $position   = strpos($request->newimage, ';');
            $sub        = substr($request->newimage, 0, $position);
            $extension  = explode('/', $sub)[1];
            $imageName  = time().'.'.$extension;
            $location   = 'backend/product/';
            $newimage      = $location.$imageName;

            Image::make($request->newimage)->resize(640, 640)->save(public_path($newimage));

            $product                = Product::find($id);
            $oldImage               = $product->image;

            if ($oldImage){

                unlink(public_path($oldImage));
                $product->category_id   = $request->category_id;
                $product->product_name  = $request->product_name;
                $product->product_code  = $request->product_code;
                $product->root          = $request->root;
                $product->buying_price  = $request->buying_price;
                $product->selling_price = $request->selling_price;
                $product->supplier_id   = $request->supplier_id;
                $product->buying_date   = $request->buying_date;
                $product->quantity      = $request->quantity;
                $product->image         = $newimage;
                $product->save();

                return Response::json('Product updated successfully');

            }else{

                $product->category_id   = $request->category_id;
                $product->product_name  = $request->product_name;
                $product->product_code  = $request->product_code;
                $product->root          = $request->root;
                $product->buying_price  = $request->buying_price;
                $product->selling_price = $request->selling_price;
                $product->supplier_id   = $request->supplier_id;
                $product->buying_date   = $request->buying_date;
                $product->quantity      = $request->quantity;
                $product->image         = $newimage;
                $product->save();

                return Response::json('Product updated successfully');

            }

        }else{

            $product                = Product::find($id);
            $oldImage               = $product->image;

            $product->category_id   = $request->category_id;
            $product->product_name  = $request->product_name;
            $product->product_code  = $request->product_code;
            $product->root          = $request->root;
            $product->buying_price  = $request->buying_price;
            $product->selling_price = $request->selling_price;
            $product->supplier_id   = $request->supplier_id;
            $product->buying_date   = $request->buying_date;
            $product->quantity      = $request->quantity;
            $product->image         = $oldImage;
            $product->save();

            return Response::json('Product updated successfully');

        }

    }

    public function updateStock(Request $request, $id){

        $validateData = $request->validate([
            'quantity' => 'required'
        ]);

        $stock = Product::find($id);
        $stock->quantity = $request->quantity;
        $stock->save();

        return Response::json('Stock updated successfully');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $product = Product::find($id);
        $oldImage = $product->image;

        if ($oldImage){

            unlink(public_path($oldImage));
            $product->delete();
            return Response::json('Product deleted successfully');

        }else{

            $product->delete();
            return Response::json('Product deleted successfully');

        }

    }
}
