<?php

namespace App\Http\Controllers;

use App\Http\Controllers\BaseController;
use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PatientController extends BaseController
{
    //  For not found response already handle on Handler.php
    public function index()
    {
        $patients = Patient::all();
        $message = (count($patients) > 0) ? 'Get All Resource' : "Data is empty";
        $data = [
            "message" => $message,
            "data" => $patients
        ];
        return response()->json($data, 200);
    }




    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'address' => 'required',
            'status' => 'required|in:Positive,Recovered,Dead',
            'phone' => 'required',
            'in_date_at' => 'required',
            'out_date_at' => 'required',
        ]);


        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }
        $patient = Patient::create($request->all());
        $data = [
            "message" => 'Resource is added successfully',
            "data" => $patient
        ];
        return response()->json($data, 201);
    }

    public function show(Patient $patient)
    {
        $data = [
            "message" => 'Get Detail Resource',
            "data" => $patient
        ];
        return response()->json($data, 200);
    }

    public function update(Request $request, Patient $patient)
    {
        $patient->update($request->all());
        $data = [
            "message" => 'Resource is update successfully',
            "data" => $patient
        ];
        return response()->json($data, 200);
    }

    public function destroy(Patient $patient)
    {
        $patient->delete();
        $data = [
            "message" => 'Resource is delete successfully',
        ];
        return response()->json($data, 200);
    }

    public function search($name)
    {
        $patient = Patient::where('name', $name)->get();
        $message = (count($patient) > 0) ? 'Get searched resource' : "Resource not found";
        $status = (count($patient) > 0) ? 200 : 404;
        $data = [
            "message" => $message,
            "data" => $patient
        ];
        return response()->json($data, $status);
    }

    function responseStatus($statusData)
    {
        $patient = Patient::where('status', $statusData)->get();
        $message = "Get " . $statusData . " Resource";
        $status = 200;
        $data = [
            "message" => $message,
            "total" => count($patient),
            "data" => $patient
        ];
        return response()->json($data, $status);
    }
    public function positive()
    {
        return $this->responseStatus("Positive");
    }

    public function recovered()
    {
        return  $this->responseStatus("recovered");
    }

    public function dead()
    {
        return  $this->responseStatus("Dead");
    }
}
