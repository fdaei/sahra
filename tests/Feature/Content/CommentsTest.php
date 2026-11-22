<?php

declare(strict_types=1);

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Database\Seeders\RolePermissionSeeder;
use Inertia\Testing\AssertableInertia as Assert;

function postForComments(bool $published = true): Post
{
    $factory = Post::factory()->withTranslations(['en' => ['title' => 'An article', 'slug' => 'an-article']]);
    return ($published ? $factory->published() : $factory)->create();
}

it('accepts comments for published posts as pending', function (): void {
    $post = postForComments();
    $this->from('/en/insights/an-article')->post('/en/insights/an-article/comments', [
        'name' => 'Reader', 'email' => 'reader@example.com', 'body' => 'Hello', 'status' => 'approved',
    ])->assertRedirect('/en/insights/an-article');
    $this->assertDatabaseHas('comments', ['post_id' => $post->id, 'status' => 'pending', 'body' => 'Hello']);
});

it('rejects invalid input and comments on draft posts', function (): void {
    postForComments();
    $this->from('/en/insights/an-article')->post('/en/insights/an-article/comments', [])->assertSessionHasErrors(['name', 'email', 'body']);
    $draft = Post::factory()->withTranslations(['en' => ['title' => 'Draft', 'slug' => 'draft']])->create();
    $this->post('/en/insights/draft/comments', ['name' => 'Reader', 'email' => 'reader@example.com', 'body' => 'Hello'])->assertNotFound();
    expect($draft->comments()->count())->toBe(0);
});

it('only exposes approved comment content and never email', function (): void {
    $post = postForComments();
    $post->comments()->create(['name' => 'Public', 'email' => 'private@example.com', 'body' => 'Visible', 'locale' => 'en', 'status' => 'approved']);
    $post->comments()->create(['name' => 'Hidden', 'email' => 'hidden@example.com', 'body' => 'Not visible', 'locale' => 'en']);
    $this->get('/en/insights/an-article')->assertOk()->assertInertia(fn (Assert $page) => $page
        ->component('Insights/Show')->has('comments', 1)->where('comments.0.name', 'Public')->missing('comments.0.email'));
});

it('allows editors to moderate comments but not users without content permissions', function (): void {
    $this->seed(RolePermissionSeeder::class);
    $editor = User::factory()->create()->assignRole('editor');
    $other = User::factory()->create();
    $comment = new Comment();
    expect($editor->can('update', $comment))->toBeTrue()->and($other->can('update', $comment))->toBeFalse();
});
