<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TermsAndConditionsController extends Controller
{
    public function getTermsAndConditions()
    {
        $termsAndConditions = 'Lorem ipsum dolor sit amet consectetur adipisicing elit. 
        Commodi veniam voluptates aperiam laborum est necessitatibus repellendus inventore quis nemo beatae odio, 
        reiciendis quaerat laboriosam harum rerum ab veritatis tempore optio.';

        return response()->json(['loremIpsum' => $termsAndConditions]);
    }
    
}
