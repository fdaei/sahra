<?php

declare(strict_types=1);

use App\Models\Post;
use App\Models\PostCategory;

function makeCategory(string $slug, ?PostCategory $parent = null): PostCategory
{
    $c = PostCategory::create(['sort_order' => 0, 'parent_id' => $parent?->id]);
    $c->setTranslations(['en' => ['name' => ucfirst($slug), 'slug' => $slug]]);

    return $c;
}

it('lists subcategory posts under the parent category filter', function (): void {
    $parent = makeCategory('marketing');
    $child = makeCategory('seo', $parent);
    $post = Post::factory()->create(['post_category_id' => $child->id]);

    app()->setLocale('en');

    expect(Post::query()->inCategory('marketing')->pluck('posts.id')->all())->toContain($post->id)
        ->and(Post::query()->inCategory('seo')->pluck('posts.id')->all())->toContain($post->id);
});

it('refuses to make a category its own descendant', function (): void {
    $parent = makeCategory('a');
    $child = makeCategory('b', $parent);

    $parent->parent_id = $child->id;

    expect(fn () => $parent->save())->toThrow(InvalidArgumentException::class);
});

it('builds ancestors from the root down', function (): void {
    $a = makeCategory('a');
    $b = makeCategory('b', $a);
    $c = makeCategory('c', $b);

    expect(array_map(fn ($x) => $x->id, $c->fresh()->ancestors()))->toBe([$a->id, $b->id]);
});
