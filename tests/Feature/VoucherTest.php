<?php

namespace Tests\Feature;

use App\Models\Voucher;
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
}
