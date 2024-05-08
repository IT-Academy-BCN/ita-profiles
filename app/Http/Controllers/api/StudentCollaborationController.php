<?php

namespace App\Http\Controllers\api;

use App\Exceptions\ResumeNotFoundException;
use App\Exceptions\StudentNotFoundException;
use App\Http\Controllers\Controller;
use App\Service\CollaborationService;
use Exception;

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
        } catch (StudentNotFoundException $e) {
            return response()->json(['message' => $e->getMessage()], $e->getCode());
        } catch (ResumeNotFoundException $e) {
            return response()->json(['message' => $e->getMessage()], $e->getCode());
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], $e->getCode() ?: 500);
        }
    }
}
