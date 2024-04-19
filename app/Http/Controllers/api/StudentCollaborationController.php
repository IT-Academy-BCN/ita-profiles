<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Service\CollaborationService;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;

//use Illuminate\Http\Request;

class StudentCollaborationController extends Controller
{
    protected $collaborationService;

    public function __construct(CollaborationService $collaborationService)
    {
        $this->collaborationService = $collaborationService;
    }
    public function __invoke($uuid)
    {
        try {
            $collaborationDetail = [
                'collaborations' => $this->collaborationService->getCollaborationDetails($uuid),
            ];
            return response()->json($collaborationDetail);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Student not found.'], 404);
        } catch (Exception $e) {
            return response()->json(['error' => 'Internal server error.'], 500);
        }
    }
}
