<?php

namespace Database\Seeders;

use App\Models\Project;
use App\Models\Tag;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProjectTagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Insertar 20 registros únicos en la tabla pivote
        for ($i = 0; $i < 20; $i++) {
            $pair = $this->getUniquePair();
            $this->insertTagProject($pair['tag_id'], $pair['project_id']);
        }
    }

    /**
     * Obtiene una combinación única de tag_id y project_id.
     */
    private function getUniquePair(): array
    {
        $existingPairs = DB::table('project_tag')->pluck('project_id', 'tag_id')->toArray();

        do {
            $tagId = Tag::inRandomOrder()->value('id');
            $projectId = Project::inRandomOrder()->value('id');
        } while (isset($existingPairs[$tagId])
                && $existingPairs[$tagId] == $projectId);

        return [
            'tag_id' => $tagId,
            'project_id' => $projectId,
        ];
    }

    /**
     * Inserta una combinación de tag_id y project_id en la tabla pivote.
     */
    private function insertTagProject(int $tagId, string $projectId): void
    {
        DB::table('project_tag')->insert([
            'tag_id' => $tagId,
            'project_id' => $projectId,
        ]);
    }
}
