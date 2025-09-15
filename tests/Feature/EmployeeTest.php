<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Employee;

class EmployeeTest extends TestCase
{
    public function testFactory()
    {
        $employee1 = Employee::factory()->programmer()->make();
        $employee1->id = '1';
        $employee1->name = 'employee1';
        $employee1->save();
        self::assertNotNull($employee1);

        $employee2 = Employee::factory()->seniorProgrammer()->create([
            'id' => '2',
            'name' => 'employee2'
        ]);

        self::assertNotNull($employee2);
    }
}
