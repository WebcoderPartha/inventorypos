<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Vat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class VatController extends Controller
{

    public function getVat(){
        $vat = Vat::where('id', 1)->first();
        return Response::json($vat);
    }

    public function updateVat(Request $request){
        $validateData = $request->validate([
            'vat' => 'required'
        ]);

        $vat = Vat::where('id', 1)->first();
        $vat->vat = $request->vat;
        $vat->save();
        return Response::json('Vat updated successfully');
    }

}
