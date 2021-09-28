<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Intervention\Image\Facades\Image;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $suppliers = Supplier::all();

        return Response::json($suppliers, 200);

    }

    public function getAllSupplier(){
        $supplier = Supplier::orderBy('id', 'ASC')->get();
        return Response::json($supplier, 200);
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
            'name'      => 'required|string',
            'email'     => 'required|unique:suppliers',
            'phone'     => 'required',
            'address'   => 'required',
            'shopname'  => 'required',
        ]);

        if ($request->photo){

            $position = strpos($request->photo, ';');
            $sub      = substr($request->photo, 0, $position);
            $extention= explode('/', $sub)[1];

            $photoName = time().'.'.$extention;
            $location = 'backend/Supplier/';
            $photo    = $location.$photoName;

            Image::make($request->photo)->resize(300, 240)->save(public_path($photo));

            $supplier            = new Supplier();
            $supplier->name      = $request->name;
            $supplier->email     = $request->email;
            $supplier->phone     = $request->phone;
            $supplier->address   = $request->address;
            $supplier->shopname  = $request->shopname;
            $supplier->photo     = $photo;
            $supplier->save();

            return Response::json('Supplier stored successfully', 200);

        }else{

            $supplier            = new Supplier();
            $supplier->name      = $request->name;
            $supplier->email     = $request->email;
            $supplier->phone     = $request->phone;
            $supplier->address   = $request->address;
            $supplier->shopname  = $request->shopname;
            $supplier->save();

            return Response::json('Supplier stored successfully', 200);
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
        $supplier = Supplier::find($id);

        return Response::json($supplier);

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
            'name'      => 'required|string',
            'email'     => 'required|unique:suppliers,email,'.$id,
            'phone'     => 'required',
            'address'   => 'required',
            'shopname'  => 'required',
        ]);

        if ($request->newphoto){
            $position   = strpos($request->newphoto, ';');
            $sub        = substr($request->newphoto, 0, $position);
            $extension  = explode('/', $sub)[1];
            $photoName  = time().'.'.$extension;
            $location   = 'backend/Supplier/';
            $newPhoto   = $location.$photoName;

            Image::make($request->newphoto)->resize(300, 240)->save(public_path($newPhoto));

            $supplier = Supplier::find($id);
            $oldPhoto = $supplier->photo;

            if ($oldPhoto){

                unlink(public_path($oldPhoto));

                $supplier->name = $request->name;
                $supplier->email = $request->email;
                $supplier->phone = $request->phone;
                $supplier->address = $request->address;
                $supplier->shopname = $request->shopname;
                $supplier->photo = $newPhoto;
                $supplier->save();

                return Response::json('Supplier Updated Successfully');

            }else{

                $supplier->name = $request->name;
                $supplier->email = $request->email;
                $supplier->phone = $request->phone;
                $supplier->address = $request->address;
                $supplier->shopname = $request->shopname;
                $supplier->photo = $newPhoto;
                $supplier->save();

                return Response::json('Supplier Updated Successfully');

            }


        }else{

            $supplier = Supplier::find($id);
            $oldPhoto = $supplier->photo;

            $supplier->name = $request->name;
            $supplier->email = $request->email;
            $supplier->phone = $request->phone;
            $supplier->address = $request->address;
            $supplier->shopname = $request->shopname;
            $supplier->photo = $oldPhoto;
            $supplier->save();

            return Response::json('Supplier Updated Successfully');

        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $supplier = Supplier::find($id);
        $oldPhoto = $supplier->photo;

        if ($oldPhoto){

            $delete = $supplier->delete();

            if ($delete){
                unlink(public_path($oldPhoto));
            }

            return Response::json('Supplier deleted successfully');

        }else{

            $delete = $supplier->delete();

            return Response::json('Supplier deleted successfully');
        }

    }
}
