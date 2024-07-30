<?php

namespace App\Console\Commands;

use App\Models\Company;
use App\Models\Project;
use Illuminate\Console\Command;
use App\Service\Resume\GetGitHubUsernamesService;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class FetchGithubRepos extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:fetch-github-repos {gitHubUsername}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch and store repos as Projects from GitHub API for Resume table';

    private $getGitHubUsernamesService;

    public function __construct(GetGitHubUsernamesService $getGitHubUsernamesService)
    {
        parent::__construct();
        $this->getGitHubUsernamesService = $getGitHubUsernamesService;
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $gitHubUsername = $this->argument('gitHubUsername');

        // First we fetch the repositories from GitHub API and store them in an array.
        $repos = $this->fetchRepositories($gitHubUsername);

        // Then we save the repositories as Projects in the database.
        $projects = $this->saveRepositoriesAsProjects($repos);

        // Finally we save the new Projects id in the array of project_ids in the resume table.
        $this->saveProjectsInResume($projects, $gitHubUsername);

        echo "Ejecutado a: " . date('Y-m-d H:i:s') . "Z\n";
    }

    protected function fetchRepositories(string $gitHubUsername): array
    {
        // $client = new Client();

        // $response = $client->get("https://api.github.com/users/{$gitHubUsername}/repos", [
        //     'headers' => [
        //         'Accept' => 'application/vnd.github.v3+json',
        //         'User-Agent' => 'LaravelApp'
        //     ]
        // ]);
        // return json_decode($response->getBody(), true);

        /* THIS IS AN ALTERNATIVE, IS WHAT I FOUND IN DOCUMENTATION... I DON'T KNOW IF IT'S BETTER OR NOT (DISCUSS PROS AND CONS).
        DIFFERENCE:
        Guzzle (new Client()): More control and flexibility, but requires more setup and boilerplate code.
        Laravel HTTP Client (Http::get()): Easier and more convenient to use within Laravel applications, 
        with a fluent interface and built-in integration. */
        $response = Http::withHeaders([
            'Accept' => 'application/vnd.github.v3+json',
            'User-Agent' => 'LaravelApp'
        ])->get("https://api.github.com/users/{$gitHubUsername}/repos");
        // We should improve this and throw an exception if response is not successfull.
        if ($response->failed()) {
            Log::error('GitHub API returned an error: ' . $response->body());
            return [];
        }

        return $response->json();
    }

    public function saveRepositoriesAsProjects(array $repos): array
    {
        $projects = [];

        foreach ($repos as $repo) {
            // Need a Company because this DB is like it is.
            $company = Company::firstOrFail();

            $project = Project::updateOrCreate(
                // Search criteria: Github repo id could be useful for this, if id exists it updates and if not,
                // creates a new Project... But for this to work I had to create the column for Project table.
                ['github_repository_id' => $repo['id']],
                [
                    'user' => $repo['owner']['login'],
                    'name' => $repo['name'],
                    'github_url' => $repo['html_url'],
                    // Laguages will be another FOLLÓN, because it's stored as an array of id, so we should match the id of language...
                    //'tags' => $repo['languages_url'],
                    // Mandatory... CACA. We should be able to null field an set a "Freelance" value in case is null.
                    'company_id' => $company->id,
                    'github_repository_id' => $repo['id'],
                ]
            );
            $projects[] = $project;
        }

        return $projects;
    }

    // Save the new Projects id in the array of project_ids in the resume table.
    public function saveProjectsInResume(array $projects, string $gitHubUsername): void
    {
        // Get the resume that matches the given GitHub username.
        $resume = $this->getGitHubUsernamesService->getResumeByGitHubUsername($gitHubUsername);
        // Get the current project_ids array
        $projectIds = json_decode($resume->project_ids, true) ?? [];
        
        foreach ($projects as $project) {
            // Add the new project ID to the array
            $projectIds[] = $project['id'];
        }
        // Update the project_ids array in the Resume
        $resume->project_ids = json_encode(array_unique($projectIds));
        // Save the updated Resume
        $resume->save();
    }
}
