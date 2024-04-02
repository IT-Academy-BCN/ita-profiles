<?php
namespace Tests\Feature;

use Tests\TestCase;

class SpecializationListTest extends TestCase
{
    public function testGetSpecializationList(){

        $response = $this->getJson(route('roles.list'));
        $response->assertStatus(200);
        $specialization_list= $response->json();
        $this->assertIsArray($specialization_list);
        foreach($specialization_list as $specialization){
            $this->assertIsString($specialization);
        }
       
    }


}

