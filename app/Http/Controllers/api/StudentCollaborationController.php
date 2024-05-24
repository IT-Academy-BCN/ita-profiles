<?php

declare(strict_types=1);

namespace App\Http\Controllers\api;

use App\Exceptions\ResumeNotFoundException;
use App\Exceptions\StudentNotFoundException;
use App\Http\Controllers\Controller;
use App\Service\CollaborationService;
use Illuminate\Http\JsonResponse;
use Exception;

class StudentCollaborationController extends Controller
{
    protected $collaborationService;

    public function __construct(CollaborationService $collaborationService)
    {
        $this->collaborationService = $collaborationService;
    }
    
    public function __invoke(string $studentId): JsonResponse
    {
        try {
            $service = $this->collaborationService->execute($studentId);
            return response()->json(['collaborations' => $service]);
        } catch (StudentNotFoundException | ResumeNotFoundException $e) {
            return response()->json(['message' => $e->getMessage()], $e->getCode());
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], $e->getCode() ?: 500);
        }
    }
}
