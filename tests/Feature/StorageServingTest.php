<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class StorageServingTest extends TestCase
{
    use RefreshDatabase;

    /**
     * This host disables PHP's symlink() function, so `storage:link` never
     * actually creates public/storage — see config/filesystems.php's
     * 'serve' => true on the public disk, which uses Laravel's built-in
     * /storage/{path} route instead. This test guards against that
     * regressing (e.g. someone "fixing" filesystems.php back to defaults).
     */
    public function test_public_disk_files_are_servable_without_a_symlink(): void
    {
        Storage::disk('public')->put('slides/test-regression.webp', 'fake-image-content');

        $response = $this->get('/storage/slides/test-regression.webp');

        $response->assertOk();
        $this->assertSame('fake-image-content', $response->streamedContent());
    }
}
