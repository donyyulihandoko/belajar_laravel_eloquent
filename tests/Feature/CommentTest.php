<?php

namespace Tests\Feature;

use App\Models\Comment;
use App\Models\Voucher;
use Database\Seeders\VoucherSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CommentTest extends TestCase
{
    public function testCreateComment()
    {
        $this->seed(VoucherSeeder::class);
        $voucher = Voucher::query()->first('id');
        $comment = new Comment();
        $comment->email = 'dony@gmail.com';
        $comment->title = 'Sample';
        $comment->comment = 'Sample Comment';
        $comment->commentable_id = $voucher->id;
        $comment->commentable_type = 'voucher';
        $comment->save();
        self::assertNotNull($comment->id);
    }

    public function testDefaultAtributeValues()
    {
        $this->seed(VoucherSeeder::class);
        $voucher = Voucher::query()->first('id');
        $comment = new Comment();
        $comment->email = 'default@gmail.com';
        $comment->commentable_id = $voucher->id;
        $comment->commentable_type = 'voucher';
        $comment->save();
        self::assertNotNull($comment->id);
        self::assertNotNull($comment->title);
        self::assertNotNull($comment->comment);
    }
}
