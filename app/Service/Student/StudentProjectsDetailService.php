<?php

declare(strict_types=1);

namespace App\Service\Student;

use App\Models\Student;
use App\Models\Project;
use App\Models\Resume;
use App\Models\Tag;
use App\Exceptions\StudentNotFoundException;
use App\Exceptions\ResumeNotFoundException;
use Illuminate\Database\Eloquent\Collection;

class StudentProjectsDetailService
{

    public function execute(string $studentId): array
    {
        $student = $this->getStudent($studentId);
        $resume = $this->getResume($student);
        $projects = $this->getProjects($resume);

        return $this->formatProjectsDetail($projects);
    }

    private function getStudent(string $studentId): Student
    {
        $student = Student::where('id', $studentId)->with('resume')->first();

        if (!$student) {
            throw new StudentNotFoundException($studentId);
        }

        return $student;
    }

    private function getResume(Student $student): Resume
    {
        $resume = $student->resume;

        if (!$resume) {
            throw new ResumeNotFoundException($student->id);
        }

        return $resume;
    }

    private function getProjects(Resume $resume): Collection
    {
        $projectIds = json_decode($resume->project_ids);
        $projects = Project::findMany($projectIds);
        return $projects;
    }

    private function formatProjectsDetail(Collection $projects): array
    {
        return
            $projects->map(function ($project) {
                $tags = Tag::findMany(json_decode($project->tags));
                return [
                    'uuid' => $project->id,
                    'project_name' => $project->name,
                    'company_name' => $project->company ? $project->company->name : 'Freelance',
                    'project_url' => $project->project_url,
                    'tags' => $tags->map(function ($tag) {
                        return [
                            'id' => $tag->id,
                            'name' => $tag->tag_name,
                        ];
                    })->toArray(),
                    'github_url' => $project->github_url,
                ];
            })->toArray();
    }
}
