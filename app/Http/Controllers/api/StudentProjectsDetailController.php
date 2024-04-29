<?php

declare(strict_types=1);

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Service\Resume\StudentProjectsDetailService;
use Illuminate\Http\JsonResponse;
use App\Exceptions\StudentNotFoundException;
use App\Exceptions\ResumeNotFoundException;
use App\Exceptions\ProjectNotFoundException;


class StudentProjectsDetailController extends Controller
{
    private $studentProjectsDetailService;

    public function __construct(StudentProjectsDetailService $studentProjectsDetailService)
    {
        $this->studentProjectsDetailService = $studentProjectsDetailService;
    }

    public function __invoke($uuid): JsonResponse
    {
        try {
            $service = $this->studentProjectsDetailService->execute($uuid);
            return response()->json(['projects' => $service]);
        } catch (StudentNotFoundException $e) {
            return response()->json(['message' => $e->getMessage()], 404);
        } catch (ProjectNotFoundException $e) {
            return response()->json(['message' => $e->getMessage()], 404);
        } catch (ResumeNotFoundException $e) {
            return response()->json(['message' => $e->getMessage()], 404);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], $e->getCode() ?: 500);
        }
    }
}
