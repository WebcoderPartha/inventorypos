<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Intervention\Image\Facades\Image;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $customer = Customer::all();
        return Response::json($customer);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

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
            'customer_name'     => 'required',
            'customer_email'    => 'required|email|unique:customers',
            'customer_phone'    => 'required|unique:customers',
            'customer_address'  => 'required',
            'customer_photo'    => ''
        ]);

        if ($request->customer_photo){

            $position                   = strpos($request->customer_photo, ';');
            $sub                        = substr($request->customer_photo, 0, $position);
            $extension                  = explode('/', $sub)[1];
            $photoName                  = time().'.'.$extension;
            $location                   = 'backend/customer/';
            $customer_photo             = $location.$photoName;
            Image::make($request->customer_photo)->resize(300, 240)->save(public_path($customer_photo));

            $customer                   = new Customer();
            $customer->customer_name    = $request->customer_name;
            $customer->customer_email   = $request->customer_email;
            $customer->customer_phone   = $request->customer_phone;
            $customer->customer_address = $request->customer_address;
            $customer->customer_photo   = $customer_photo;
            $customer->save();

            return Response::json("Customer stored successfully");

        }else{

            $customer                   = new Customer();
            $customer->customer_name    = $request->customer_name;
            $customer->customer_email   = $request->customer_email;
            $customer->customer_phone   = $request->customer_phone;
            $customer->customer_address = $request->customer_address;
            $customer->save();

            return Response::json("Customer stored successfully");

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
        $customer = Customer::find($id);
        return Response::json($customer);
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
            'customer_name'     => 'required',
            'customer_email'    => 'required|email|unique:customers,customer_email,'.$id,
            'customer_phone'    => 'required|unique:customers,customer_phone,'.$id,
            'customer_address'  => 'required',
            'customer_photo'    => '',
        ]);

        if ($request->new_customer_photo){

            $postion            = strpos($request->new_customer_photo, ';');
            $sub                = substr($request->new_customer_photo, 0, $postion);
            $extension          = explode('/', $sub)[1];
            $imageName          = time().'.'.$extension;
            $location           = 'backend/customer/';
            $new_customer_photo = $location.$imageName;
            Image::make($request->new_customer_photo)->resize(300, 240)->save(public_path($new_customer_photo));

            $customer                       = Customer::where('id', $request->id)->first();
            $oldPhoto                       = $customer->customer_photo;
            if ($oldPhoto){

                unlink(public_path($oldPhoto));
                $customer->customer_name    = $request->customer_name;
                $customer->customer_email   = $request->customer_email;
                $customer->customer_phone   = $request->customer_phone;
                $customer->customer_address = $request->customer_address;
                $customer->customer_photo   = $new_customer_photo;
                $customer->save();
                return Response::json("Customer updated successfully");

            }else{

                $customer->customer_name    = $request->customer_name;
                $customer->customer_email   = $request->customer_email;
                $customer->customer_phone   = $request->customer_phone;
                $customer->customer_address = $request->customer_address;
                $customer->customer_photo   = $new_customer_photo;
                $customer->save();
                return Response::json("Customer updated successfully");

            }


        }else{

            $customer                   = Customer::where('id', $request->id)->first();
            $oldPhoto = $customer->customer_photo;
            $customer->customer_name    = $request->customer_name;
            $customer->customer_email   = $request->customer_email;
            $customer->customer_phone   = $request->customer_phone;
            $customer->customer_address = $request->customer_address;
            $customer->customer_photo   = $oldPhoto;
            $customer->save();
            return Response::json("Customer updated successfully");

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
        //
    }
}
