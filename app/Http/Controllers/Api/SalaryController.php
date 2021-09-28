<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Salary;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class SalaryController extends Controller
{

    public function storePaySalary(Request $request, $id){

        $validateData = $request->validate([
            'employee_id'   => '',
            'salary_amount' => '',
            'salary_date'   => '',
            'salary_month'  => 'required',
            'salary_year'   => '',
        ]);

        $salary = Salary::where([
            'employee_id' => $id,
            'salary_month' => $request->salary_month
        ])->first();

        if ($salary){

            return Response::json("<span style='color:red'>Already paid this Employee</span>");

        }else{

            $salary = new Salary();
            $salary->employee_id = $id;
            $salary->salary_amount = $request->salary;
            $salary->salary_date = date('d-m-Y');
            $salary->salary_month = $request->salary_month;
            $salary->salary_year  = date('Y');
            $salary->save();
            return Response::json("<span>Congrats! Salary paid</span>");

        }

    }

    public function getAllSalary(){

        $salary = Salary::select('salary_month')->groupBy('salary_month')->get();
        return Response::json($salary);

    }

    public function viewPaidByMonth($month){

        $salary = Salary::with('employee')->where('salary_month', $month)->get();
        return Response::json($salary);

    }

    public function Show($id){
        $salary = Salary::with('employee')->find($id);
        return Response::json($salary);
    }

    public function updatePaidSalary(Request $request, $id){
        $validateData = $request->validate([
            'employee_id'   => '',
            'salary_amount' => 'required',
            'salary_date'   => '',
            'salary_month'  => 'required',
            'salary_year'   => '',
        ]);

        $salary = Salary::where('id', $id)->first();

            $salary->salary_amount  = $request->salary_amount;
            $salary->salary_month   = $request->salary_month;
            $salary->save();
            return Response::json("Salary Updated Successfully");






    }

}
