<?php

namespace Database\Seeders;

use App\Models\Comment;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Voucher;


class CommentSeeder extends Seeder
{

    public function run(): void
    {
        $this->createCommentProduct();
        $this->createCommentVoucher();
    }
    private function createCommentProduct()
    {
        $product = Product::query()->find('1');
        $comment = new Comment();
        $comment->email = 'donyyuli@gmail.com';
        $comment->title = 'product comment';
        $comment->comment = 'product comment sample';
        $comment->commentable_id = $product->id;
        $comment->commentable_type = 'product';
        $comment->save();
    }
    private function createCommentVoucher()
    {
        $voucher = Voucher::query()->first('id');
        $comment = new Comment();
        $comment->email = 'donyyuli@gmail.com';
        $comment->title = 'voucher comment';
        $comment->comment = 'voucher comment';
        $comment->commentable_id = $voucher->id;
        $comment->commentable_type = 'voucher';
        $comment->save();
    }
}
