<?php

namespace App\Http\Controllers\api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Service\TermsAndConditionsService;
use Exception;

class TermsAndConditionsController extends Controller
{
    protected $termsAndConditionsService;

    public function __construct(TermsAndConditionsService $termsAndConditionsService)
    {
        $this->termsAndConditionsService = $termsAndConditionsService;
    }

    public function getTermsAndConditions()
    {
        try {
            $termsAndConditions = $this->termsAndConditionsService->getTermsAndConditions();
            return response()->json(['content' => $termsAndConditions], 200);
        } catch (Exception $e) {
            return response()->json(['error' => 'Hem tingut un error amb els termes i condicions', 'message' => $e->getMessage()], 500);
        }
    }
}

