<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Service\Resume\GetGitHubUsernamesService;
use GuzzleHttp\Client;

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
    protected $description = 'Fetch GitHub repos for github_url fields in resumes table';

    // Ha agregado aquí el service para luego llamar a la función, 
    // no sé si lo debemos hacer así o directamente desde el handle.
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
        // Aquí llamaríamos al service.
        //$gitHubUsernames = $this->getGitHubUsernamesService->GetGitHubUsernames();

        $client = new Client();

        // Y creo que algo así debería ser el foreach para recorrer todos los users, pero no estoy del todo seguro
        // foreach ($gitHubUsernames as $user) {
        //     $response = $client->get("https://api.github.com/users/{$user['github_username']}/repos", [
        //         'headers' => [
        //             'Accept' => 'application/vnd.github.v3+json',
        //             'User-Agent' => 'LaravelApp'
        //         ]
        //     ]);

        //     $repos = json_decode($response->getBody(), true);

        //     foreach ($repos as $repo) {
        //         $this->info("User: {$user['github_username']}, Repository Name: " . $repo['name']);
        //     }
        // }

        $response = $client->get("https://api.github.com/users/StephaneCarteaux/repos", [
            'headers' => [
                'Accept' => 'application/vnd.github.v3+json',
                'User-Agent' => 'LaravelApp'
            ]
        ]);

        $repos = json_decode($response->getBody(), true);

        foreach ($repos as $repo) {
            $this->info("Repository Name: " . $repo['name']);
            //dd ($this->info);
        }
    }
}
