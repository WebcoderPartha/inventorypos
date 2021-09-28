<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Expense;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class ExpenseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $expense = Expense::all();
        return Response::json($expense);
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
            'expense_details'   => 'required|string',
            'expense_amount'    => 'required',
            'expense_date'      => ''
        ]);

        $expense = new Expense();

        $expense->expense_details   = $request->expense_details;
        $expense->expense_amount    = $request->expense_amount;
        $expense->expense_date      = date('d-m-Y', strtotime($request->expense_date));
        $expense->save();

        return Response::json('Expense stored successfully', 200);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $expense = Expense::find($id);
        return Response::json($expense, 200);
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
            'expense_details'   => 'required|string',
            'expense_amount'    => 'required',
            'expense_date'      => ''
        ]);

        $expense = Expense::find($id);
        $expense->expense_details = $request->expense_details;
        $expense->expense_amount = $request->expense_amount;
        $expense->expense_date = date('d-m-Y', strtotime($request->expense_date));
        $expense->save();

        return Response::json('Expense updated successfully', 200);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $expense = Expense::find($id);
        $expense->delete();
        return Response::json('Expense removed successfully', 200);

    }
}
