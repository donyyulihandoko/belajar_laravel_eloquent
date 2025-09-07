<?php

namespace Tests\Feature;

use App\Models\Comment;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CommentTest extends TestCase
{
    public function testCreateComment()
    {
        $comment = new Comment();
        $comment->email = 'dony@gmail.com';
        $comment->title = 'Sample';
        $comment->comment = 'Sample Comment';
        $comment->save();
        self::assertNotNull($comment->id);
    }
}
