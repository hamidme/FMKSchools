<?php

namespace Tests\Feature;

use Tests\TestCase;

class FilamentUploadDiskTest extends TestCase
{
    /**
     * Filament's default upload disk inherits Laravel's filesystems.default,
     * which is "local" in this project's .env — not "public". Every image
     * ever uploaded through the admin panel silently went to storage/app/
     * private/ instead, invisible to the site's public-facing pages (which
     * correctly read from the "public" disk). Every FileUpload/ImageColumn
     * must set ->disk('public') explicitly, or this regresses silently.
     *
     * Filament's Table/Schema objects require a live Livewire component to
     * instantiate, which makes asserting this behaviorally impractical in a
     * unit-style test — so this checks the source directly instead.
     */
    public function test_every_file_upload_and_image_column_specifies_the_public_disk(): void
    {
        $files = array_merge(
            glob(app_path('Filament/Resources/*/Schemas/*.php')),
            glob(app_path('Filament/Resources/*/Tables/*.php')),
        );

        $this->assertNotEmpty($files, 'Expected to find Filament resource schema/table files.');

        foreach ($files as $file) {
            $contents = file_get_contents($file);

            if (! str_contains($contents, 'FileUpload::make') && ! str_contains($contents, 'ImageColumn::make')) {
                continue;
            }

            // Every FileUpload/ImageColumn block in the file must be paired
            // with an explicit ->disk('public') call somewhere in the file.
            $uploadCount = substr_count($contents, 'FileUpload::make') + substr_count($contents, 'ImageColumn::make');
            $diskCount = substr_count($contents, "->disk('public')");

            $this->assertGreaterThanOrEqual(
                $uploadCount,
                $diskCount,
                basename($file)." has a FileUpload/ImageColumn without an explicit ->disk('public') call."
            );
        }
    }
}
