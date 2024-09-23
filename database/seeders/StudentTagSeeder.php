<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Student;
use App\Models\Tag;

class StudentTagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Insertar 20 registros únicos en la tabla pivote
        for ($i = 0; $i < 20; $i++) {
            $pair = $this->getUniquePair();
            $this->insertTagStudent($pair['tag_id'], $pair['student_id']);
        }
    }

    /**
     * Obtiene una combinación única de tag_id y student_id.
     */
    private function getUniquePair(): array
    {
        $existingPairs = DB::table('student_tag')->pluck('student_id', 'tag_id')->toArray();

        do {
            $tagId = Tag::inRandomOrder()->value('id');
            $studentId = Student::inRandomOrder()->value('id');
        } while (isset($existingPairs[$tagId])
                && $existingPairs[$tagId] == $studentId);

        return [
            'tag_id' => $tagId,
            'student_id' => $studentId,
        ];
    }

    /**
     * Inserta una combinación de tag_id y student_id en la tabla pivote.
     */
    private function insertTagStudent(int $tagId, string $studentId): void
    {
        DB::table('student_tag')->insert([
            'tag_id' => $tagId,
            'student_id' => $studentId,
        ]);
    }
}
