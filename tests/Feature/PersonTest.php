<?php

namespace Tests\Feature;

use App\Models\Person;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Carbon\Carbon;
use App\Models\Address;

class PersonTest extends TestCase
{
    public function testPerson()
    {
        $person = new Person();
        $person->first_name = 'Dony';
        $person->last_name = 'Yuli';
        $person->save();

        self::assertEquals('DONY Yuli', $person->fullName);

        $person->fullName = 'Dody Sunjaya';
        $person->save();

        self::assertEquals('DODY Sunjaya', $person->full_name);
        self::assertEquals('DODY', $person->first_name);
    }
    public function testAttributeCasting()
    {
        $person = new Person();
        $person->first_name = "Eko";
        $person->last_name = "Khannedy";
        $person->save();

        self::assertNotNull($person->created_at);
        self::assertNotNull($person->updated_at);
        self::assertInstanceOf(Carbon::class, $person->created_at);
        self::assertInstanceOf(Carbon::class, $person->updated_at);
    }

    public function testCustomCasts()
    {
        $person = new Person();
        $person->first_name = "Eko";
        $person->last_name = "Khannedy";
        $person->address = new Address("Jalan Belum Jadi", "Jakarta", "Indonesia", "11111");
        $person->save();

        self::assertNotNull($person->created_at);
        self::assertNotNull($person->updated_at);
        self::assertInstanceOf(Carbon::class, $person->created_at);
        self::assertInstanceOf(Carbon::class, $person->updated_at);
        self::assertEquals("Jalan Belum Jadi", $person->address->street);
        self::assertEquals("Jakarta", $person->address->city);
        self::assertEquals("Indonesia", $person->address->country);
        self::assertEquals("11111", $person->address->postal_code);
    }
}
