<?php

namespace App\Filament\Pages;

use App\Models\SiteImage;
use BackedEnum;
use Filament\Actions\Action;
use Filament\Forms\Components\FileUpload;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Schemas\Components\Actions;
use Filament\Schemas\Components\EmbeddedSchema;
use Filament\Schemas\Components\Form;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\HtmlString;

/**
 * One upload per fixed image slot on the public site (config/site-images.php).
 * Uploading replaces the bundled image; removing the upload restores it.
 */
class SiteImages extends Page
{
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedPhoto;

    protected static ?string $navigationLabel = 'Site Images';

    protected static ?int $navigationSort = 1;

    protected static ?string $title = 'Site Images';

    protected ?string $subheading = 'Replace any photo on the website. Remove an upload to go back to the original image.';

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill(SiteImage::pluck('path', 'key')->all());
    }

    public function form(Schema $schema): Schema
    {
        $sections = [];

        foreach (config('site-images') as $group => $slots) {
            $fields = [];

            foreach ($slots as $key => $slot) {
                $fields[] = FileUpload::make($key)
                    ->label($slot['label'])
                    ->image()
                    ->disk('public')
                    ->directory('site-images')
                    ->maxSize(5120)
                    ->helperText($this->describeDefault($slot));
            }

            $sections[] = Section::make($group)
                ->columns(['md' => 2, 'xl' => 3])
                ->collapsible()
                ->components($fields);
        }

        return $schema
            ->components($sections)
            ->statePath('data');
    }

    public function content(Schema $schema): Schema
    {
        return $schema->components([
            Form::make([EmbeddedSchema::make('form')])
                ->id('form')
                ->livewireSubmitHandler('save')
                ->footer([
                    Actions::make([
                        Action::make('save')
                            ->label('Save changes')
                            ->submit('save'),
                    ])->sticky(),
                ]),
        ]);
    }

    public function save(): void
    {
        $state = $this->form->getState();
        $previous = SiteImage::pluck('path', 'key')->all();
        $orphaned = [];

        DB::transaction(function () use ($state, $previous, &$orphaned) {
            foreach (array_keys(SiteImage::slots()) as $key) {
                $path = $state[$key] ?? null;
                $old = $previous[$key] ?? null;

                if ($path === $old) {
                    continue;
                }

                if ($path === null) {
                    SiteImage::where('key', $key)->first()?->delete();
                } else {
                    SiteImage::updateOrCreate(['key' => $key], ['path' => $path]);
                }

                if ($old !== null) {
                    $orphaned[] = $old;
                }
            }
        });

        // Only after the DB commit, so a failed save never loses a live image.
        Storage::disk('public')->delete($orphaned);

        Notification::make()
            ->success()
            ->title('Images saved')
            ->body('Changes are live on the website now.')
            ->send();
    }

    protected function describeDefault(array $slot): HtmlString
    {
        $hint = e($slot['hint'] ?? '');

        if (! is_file(public_path($slot['default']))) {
            return new HtmlString("{$hint} <em>No original photo — a plain colour block shows until you upload one.</em>");
        }

        $src = e($slot['default']);

        return new HtmlString(
            "<span style=\"display:flex;gap:.75rem;align-items:center\">"
            ."<img src=\"{$src}\" alt=\"\" style=\"height:3rem;width:4rem;object-fit:cover;border-radius:.375rem;flex-shrink:0\">"
            ."<span>{$hint} Original shown left.</span></span>"
        );
    }
}
