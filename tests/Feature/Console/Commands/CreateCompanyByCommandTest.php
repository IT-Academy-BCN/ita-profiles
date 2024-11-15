<?php

namespace Tests\Feature;

use App\Http\Controllers\app\Http\Controllers\api\Company\CreateCompanyController;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Models\Company;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;


class CreateCompanyByCommandTest extends TestCase
{
   use DatabaseTransactions;

   public function testCompanyModelExists() : void
   {
       $this->assertTrue(class_exists(Company::class), "The Company model does not exist.");
   }

   public function testCanInstantiateController(): void
   {
       $companyController = new CreateCompanyController();

       $this->assertInstanceOf(CreateCompanyController::class, $companyController);
   }

   public function testCompanyCanBeCreatedViaCommand(): void
   {
       $this->artisan('create:company')
           ->expectsQuestion('Nombre de la compañia:', 'Test Company')
           ->expectsQuestion('Email:', 'test@test.es')
           ->expectsQuestion('CIF:', 'B12345678')
           ->expectsQuestion('Localizacion:', 'Test Location')
           ->expectsQuestion('Pagina web:', 'https://test.com')
           ->assertExitCode(0);

       $this->assertDatabaseHas('companies', [
           'name' => 'Test Company',
           'email' => 'test@localhost',
           'CIF' => 'B12345678',
           'location' => 'Test Location',
           'website' => 'https://test.com/',
       ]);
   }



}
