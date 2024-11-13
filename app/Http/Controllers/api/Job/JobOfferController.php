<?php

namespace App\Http\Controllers\Api\Job;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\JobOffer;
use Illuminate\Support\Facades\Validator;

class JobOfferController extends Controller
{
    //Create job offer
    public function createJobOffer(Request $request)
    {
        
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'description' => 'required',
            'location' => 'required',
            'skills' => 'required',
            'salary' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        $jobOffer = JobOffer::create([
            'title' => $request->title,
            'description' => $request->description,
            'location' => $request->location,
            'skills' => $request->skills,
            'salary' => $request->salary,
        ]);

        return response()->json(['message' => 'Oferta de feina creada amb èxit', 'jobOffer' => $jobOffer], 201);
    }
}
