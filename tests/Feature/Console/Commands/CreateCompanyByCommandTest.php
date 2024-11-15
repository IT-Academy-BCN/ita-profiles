<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Models\Company;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;


class CreateCompanyByCommandTest extends TestCase
{
   use DatabaseTransactions;

   public function testCompanyModelExists()
   {
       $this->assertTrue(class_exists(Company::class), "The Company model does not exist.");
   }

   public function testCanInstantiateController(): void
   {
       $companyController = new CreateCompanyController();

       $this->assertInstanceOf(CreateCompanyController::class, $companyController);
   }

}
