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
    protected $signature = 'app:fetch-github-repos';

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
        // This is for now, it should be passed as argument from the listener to the Service.
        $project = Project::firstOrFail();
        // The service should be called in the listener, not here.
        $gitHubUsername = $this->getGitHubUsernamesService->getSingleGitHubUsername($project);

        // First we fetch the repositories from GitHub API and store them in an array.
        $repos = $this->fetchRepositories($gitHubUsername);

        // Then we store the repositories as Projects in the database.
        $this->storeRepositoriesAsProjects($repos);

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

    public function storeRepositoriesAsProjects(array $repos): void
    {
        foreach ($repos as $repo) {
            // Need a fucking Company because this DB is a CACA.
            $company = Company::firstOrFail();

            $project = Project::create([
                'user' => $repo['owner']['login'],
                'name' => $repo['name'],
                'github_url' => $repo['html_url'],
                // Laguages will be another FOLLON, because it's store as an array of id, so we should match the id of language...
                //'tags' => $repo['languages_url'],
                // Mandatory... CACA.
                'company_id' => $company->id,
                // Github repo id could be useful in order to know if it should create or update a Project...
                // But we should create the column for Project table.
                // 'github_repository_id' => $repo['id'],
            ]);

            $this->info("Project created: " . $project);
        }
    }
}
