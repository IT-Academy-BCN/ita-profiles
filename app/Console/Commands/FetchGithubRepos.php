<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Service\Resume\GetGitHubUsernames;
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

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // $gitHubUsernames = GetGitHubUsernames::getGithubUsernames();
        $client = new Client();



            $response = $client->get("https://api.github.com/users/StephaneCarteaux/repos", [
                'headers' => [
                    'Accept' => 'application/vnd.github.v3+json',
                    'User-Agent' => 'LaravelApp'
                ]
            ]);

            $repos = json_decode($response->getBody(), true);

            foreach($repos as $repo) {
                $this->info("Repository Name: " . $repo['name']);
                //dd ($this->info);
            }

    }
}
