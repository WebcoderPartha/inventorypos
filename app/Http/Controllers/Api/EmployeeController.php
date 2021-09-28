<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Intervention\Image\Facades\Image;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $employee = Employee::all();

        return Response::json($employee);
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
            'name' => 'required|string|unique:employees',
            'email' => 'required|unique:employees|email',
            'phone' => 'required|unique:employees',
//            'address' => 'required',
//            'salary' => 'required',
//            'joindate' => 'required'
        ]);

        if ($request->photo){
            $position = strpos($request->photo, ';');
            $sub = substr($request->photo, 0, $position);
            $extention = explode('/', $sub)[1];

            $photoName = time().'.'.$extention;

            $directory = 'backend/employee/';
            $photosave = $directory.$photoName;

            $image = Image::make($request->photo)->resize(240, 200);
            $image->save(public_path($directory.$photoName));

            $employee = new Employee();
            $employee->name = $request->name;
            $employee->email = $request->email;
            $employee->phone = $request->phone;
            $employee->address = $request->address;
            $employee->salary = $request->salary;
            $employee->nid = $request->nid;
            $employee->photo = $photosave;
            $employee->joindate = $request->joindate;
            $employee->save();

            return Response::json('Employee stored successfully');

        }else{

            $employee = new Employee();
            $employee->name = $request->name;
            $employee->email = $request->email;
            $employee->phone = $request->phone;
            $employee->address = $request->address;
            $employee->salary = $request->salary;
            $employee->nid = $request->nid;
            $employee->joindate = $request->joindate;
            $employee->save();

            return Response::json('Employee stored successfully without photo');

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
        $employee = Employee::find($id);
        return Response::json($employee, 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

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
            'name' => 'required|string|unique:employees,name,'.$id,
            'email' => 'required|unique:employees,email,'.$id,
            'phone' => 'required|unique:employees,phone,'.$id,
        ]);


        if ($request->newphoto){

            $position = strpos($request->newphoto, ';');
            $sub = substr($request->newphoto, 0, $position);
            $extention = explode('/', $sub)[1];

            $photoName  = time().'.'.$extention;
            $location   = 'backend/employee/';
            $photo = $location.$photoName;

            Image::make($request->newphoto)->resize(300, 250)->save(public_path($location.$photoName));

            $employee = Employee::find($id);
            $oldPhoto = $employee->photo;
            if ($oldPhoto){
                unlink(public_path($oldPhoto));
            }

            $employee->name = $request->name;
            $employee->email = $request->email;
            $employee->phone = $request->phone;
            $employee->address = $request->address;
            $employee->salary = $request->salary;
            $employee->nid = $request->nid;
            $employee->joindate = $request->joindate;
            $employee->photo = $photo;
            $employee->save();

            return Response::json('Updated successfully ');


        }else{

            $employee = Employee::find($id);
            $oldPhoto = $employee->photo;

            $employee->name = $request->name;
            $employee->email = $request->email;
            $employee->phone = $request->phone;
            $employee->address = $request->address;
            $employee->salary = $request->salary;
            $employee->nid = $request->nid;
            $employee->joindate = $request->joindate;
            $employee->photo = $oldPhoto;
            $employee->save();

            return Response::json('Updated successfully ');

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
        $employee = Employee::find($id);

        $photoPath = $employee->photo;

        if ($photoPath !== null){
            $delete = $employee->delete();
            if ($delete){
                unlink(public_path($photoPath));
            }
            return Response::json('Deleted successfully');
        }else{
            $employee = Employee::find($id);
            $delete = $employee->delete();

            return Response::json('Deleted successfully');
        }

    }
}
