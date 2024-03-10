<?php 

namespace Tests\Unit;

use App\Http\Controllers\api\StudentController;
use PHPUnit\Framework\TestCase;

class StudentControllerIndexTest extends TestCase
{

    public function testCanInstantiate(): void
    {
        $controller = new StudentController();
        $this->assertInstanceOf(StudentController::class, $controller);
    }

}

