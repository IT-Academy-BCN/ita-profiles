<?php

declare(strict_types=1);

namespace App\Http\Controllers\api\Job;

use App\Http\Controllers\Controller;
use App\Http\Requests\Job\CreateJobOfferRequest;
use App\Models\JobOffer;


class JobOfferController extends Controller
{
    
    public function createJobOffer(CreateJobOfferRequest $request)
    {
        $jobOffer = JobOffer::create($request->validated());

        return response()->json(['message' => '🟢 Oferta de feina creada amb èxit', 'jobOffer' => $jobOffer], 201);
    }
}
