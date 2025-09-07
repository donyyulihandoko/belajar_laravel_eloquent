<?php

namespace Tests\Feature;

use App\Models\Voucher;
use Database\Seeders\VoucherSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class VoucherTest extends TestCase
{
    public function testCreateVoucher()
    {
        $voucher = new Voucher();
        $voucher->name = 'Sample Voucher';
        $voucher->voucher_code = '123234';
        $voucher->save();
        self::assertNotNull($voucher->id);
    }

    public function testCreateVoucherUuid()
    {
        $voucher = new Voucher();
        $voucher->name = 'Sample Voucher';
        $voucher->save();
        self::assertNotNull($voucher->id);
        self::assertNotNull($voucher->voucher_code);
    }

    public function testSoftDelete()
    {
        $this->seed(VoucherSeeder::class);
        $voucher = Voucher::query()->where('name', 'Sample Voucher')->first();
        $voucher->delete();

        $voucher = Voucher::query()->where('name', 'Sample Voucher')->first();
        self::assertNull($voucher);


        $voucher = Voucher::query()->withTrashed()->where('name', 'Sample Voucher')->first();
        self::assertNotNull($voucher);
    }

    public function testLocalScope()
    {
        $voucher = new Voucher();
        $voucher->name = 'sample voucher';
        $voucher->is_active = true;
        $voucher->save();
        $result = Voucher::active()->count();
        self::assertEquals(1, $result);

        $result = Voucher::nonActive()->count();
        self::assertEquals(0, $result);
    }
}
