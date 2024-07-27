<?php

namespace App\Console\Commands;

use App\Models\Company;
use App\Models\Project;
use Illuminate\Console\Command;
use App\Service\Resume\GetGitHubUsernamesService;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Http;

class FetchGithubRepos extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:fetch-github-repos {--username=}';

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
        $gitHubUsername = $this->option('username');
        // First we fetch the repositories from GitHub API and store them in an array.
        $repos = $this->fetchRepositories($gitHubUsername);

        // Then we save the repositories as Projects in the database.
        // $this->saveRepositoriesAsProjects($repos);

        // Get the resume that matches the given GitHub username.
        // $resume = $this->getGitHubUsernamesService->getResumeByGitHubUsername($gitHubUsername);
        // Pluck the repositories in the array of projects for the given resume.

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

        /* THIS IS AN ALTERNATIVE, IS WHAT I FOUND IN DOCUMENTATION... 
        I DON'T KNOW IF IT'S BETTER OR NOT. WE SHOULD DISCUSS PROS AND CONS.
        DIFFERENCE:
        Guzzle (new Client()): More control and flexibility, but requires more setup and boilerplate code.
        Laravel HTTP Client (Http::get()): Easier and more convenient to use within Laravel applications, 
        with a fluent interface and built-in integration.
        */
        $response = Http::withHeaders([
            'Accept' => 'application/vnd.github.v3+json',
            'User-Agent' => 'LaravelApp'
        ])->get("https://api.github.com/users/{$gitHubUsername}/repos");

        return $response->json();
    }

    public function saveRepositoriesAsProjects(array $repos): void
    {
        foreach ($repos as $repo) {
            // Need a fucking Company because this DB is a CACA.
            $company = Company::firstOrFail();

            $project = Project::updateOrCreate(
                // Search criteria: Github repo id could be useful for this, if id exists it updates and if not,
                // creates a new Project... But for this to work I had to create the column for Project table.
                ['github_repository_id' => $repo['id']], 
                [
                    'user' => $repo['owner']['login'],
                    'name' => $repo['name'],
                    'github_url' => $repo['html_url'],
                    // Laguages will be another FOLLÓN, because it's store as an array of id, so we should match the id of language...
                    //'tags' => $repo['languages_url'],
                    // Mandatory... CACA. We should be able to null field an set a "Freelance" value in case is null.
                    'company_id' => $company->id,
                    'github_repository_id' => $repo['id'],
                ]
            );

            $this->info("Project created or updated: " . $project);
        }
    }

    // Save the new Projects id in the array of project_ids in the resume table.
    public function saveProjectsInResume(array $projects): void
    {

    }
}
