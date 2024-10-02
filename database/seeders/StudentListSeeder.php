<?php

namespace Database\Seeders;

use App\Models\Resume;
use App\Models\Collaboration;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StudentListSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        
        $number = 30;
        
        $resumes = Resume::factory()->count($number)->create();
        $collaborations = Collaboration::factory()->count(2*$number)->create();
        
        $counter = 0;
        foreach($resumes as $resume){
			//if($counter <= $number){
				for ($i = 0; $i < 2; $i++) {
					DB::table('resume_collaboration')->insert(
						[
							'resume_id' => $resumes[$counter]->id,
							'collaboration_id' => $collaborations[$counter*2 + $i]->id,
						]
					);
				}
			//}
			$counter++;	
		}
        
    }
}
