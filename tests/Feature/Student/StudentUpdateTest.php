<?php

namespace Tests\Feature\Student;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;
use Illuminate\Support\Str;

class StudentUpdateTest extends TestCase
{
    use RefreshDatabase;

    public function verifyOrCreateRolesAndPermissions()
    {
        if (!Role::where('name', 'student')->exists()) {
            $student = Role::create(['name' => 'student']);
        }
    
        if (!Permission::where('name', 'update.student')->exists()) {
            $updateStudent = Permission::create(['name' => 'update.student']);
        }
       
        $student -> syncPermissions($updateStudent);
    }

   
   /** @test */
   public function student_data_can_be_updated_by_himself(): void
   {
        $this->verifyOrCreateRolesAndPermissions();
     
        $user = User::create([
           'name' => 'John',
           'surname' => 'Doe',
           'dni' => '53671299V',
           'email' => 'john@example.com',
           'password' => bcrypt($password ='password')
       ]);

        $user -> student()->create([
           'subtitle' => 'Enginyer Informàtic i Programador.',
           'bootcamp'=> 'PHP Developer',
       ]);

        $user -> assignRole('student');

        $response =  $this->post('api/v1/login', [
         'email' => 'john@example.com',
         'password' =>$password
       ]);

       $this->assertAuthenticatedAs($user);

       $this->actingAs($user, 'api');

        $data = [
            'name' => 'Johnny',
            'surname' => 'Doe',
            'email' => 'johnny@example.com',
            'subtitle' => 'Enginyer Informàtic i Programador',
            'bootcamp'=> 'PHP Developer',
            'about'=> 'Lorem ipsum dolor sit amet.',
            'cv'=> 'New Curriculum',
            'linkedin'=> 'http://www.linkedin.com/johnnydoe',
            'github'=> 'http://www.github.com/johnnydoe',
        ];

       $response = $this->withHeaders(['Accept'=> 'application/json'])->put('api/v1/students/'.$user->student->id, $data);
      
       $user = $user -> fresh();
       $student = $user -> student -> fresh();

       $response->assertStatus(200);
       $response->assertHeader('Content-Type', 'application/json');
      
       $this -> assertEquals($user->name, Str::lower($data['name']));
       $this -> assertEquals($user->email, Str::lower($data['email']));
       $this -> assertEquals($student->cv, $data['cv']);
    }

    
    /** @test */
   public function student_data_cannot_be_updated_by_another_student(): void
   {
        $this->verifyOrCreateRolesAndPermissions();
     
        $user = User::create([
           'name' => 'John',
           'surname' => 'Doe',
           'dni' => '53671299V',
           'email' => 'john@example.com',
           'password' => bcrypt($password ='password')
       ]);

        $user -> student()->create([
           'subtitle' => 'Enginyer Informàtic i Programador.',
           'bootcamp'=> 'PHP Developer',
       ]);

        $user -> assignRole('student');

        $response =  $this->post('api/v1/login', [
         'email' => 'john@example.com',
         'password' =>$password
       ]);

       $this->assertAuthenticatedAs($user);

       $this->actingAs($user, 'api');

        $data = [
            'name' => 'Johnny',
            'surname' => 'Doe',
            'email' => 'johnny@example.com',
            'subtitle' => 'Enginyer Informàtic i Programador',
            'bootcamp'=> 'PHP Developer',
            'about'=> 'Lorem ipsum dolor sit amet.',
            'cv'=> 'New Curriculum',
            'linkedin'=> 'http://www.linkedin.com/johnnydoe',
            'github'=> 'http://www.github.com/johnnydoe',
        ];

       $response = $this->withHeaders(['Accept'=> 'application/json'])->put('api/v1/students/2', $data);
      
       $user = $user -> fresh();
       $student = $user -> student -> fresh();

       $response->assertStatus(401);
    
    }

}