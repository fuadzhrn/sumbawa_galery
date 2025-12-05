<?php

namespace App\Console\Commands;

use App\Models\KaryaSeni;
use App\Models\SambutanContent;
use App\Models\SliderImage;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class MigrateUploadPaths extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'migrate:upload-paths {--dry-run}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Migrate file paths from storage/ to assets/ format and move files to public/assets';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $dryRun = $this->option('dry-run');
        
        if ($dryRun) {
            $this->info('Running in DRY-RUN mode. No changes will be made.');
        }

        $this->info('Starting migration of upload paths...');
        $this->line('');

        // Migrate KaryaSeni media_path
        $this->migrateKaryaSeniMedia($dryRun);
        
        // Migrate KaryaSeni thumbnails
        $this->migrateKaryaSeniThumbnails($dryRun);
        
        // Migrate SliderImage files
        $this->migrateSliderImages($dryRun);
        
        // Migrate SambutanContent images
        $this->migrateSambutanContent($dryRun);

        $this->info('');
        $this->info('Migration complete!');
    }

    /**
     * Migrate KaryaSeni media files
     */
    protected function migrateKaryaSeniMedia($dryRun)
    {
        $this->info('Migrating KaryaSeni media files...');
        
        $karya = KaryaSeni::where('media_path', 'like', 'storage/%')->get();
        $count = 0;

        foreach ($karya as $item) {
            // Skip URLs
            if (filter_var($item->media_path, FILTER_VALIDATE_URL)) {
                continue;
            }

            $oldPath = $item->media_path;
            
            // Convert storage/karya_seni/X/file to assets/karya_seni/X/file
            $newPath = str_replace('storage/', '', $oldPath);
            
            $this->line("  KaryaSeni ID {$item->id}: {$oldPath} → {$newPath}");
            
            if (!$dryRun) {
                $item->update(['media_path' => $newPath]);
                $count++;
            }
        }

        $this->info("  Updated {$count} KaryaSeni media paths.");
        $this->line('');
    }

    /**
     * Migrate KaryaSeni thumbnails
     */
    protected function migrateKaryaSeniThumbnails($dryRun)
    {
        $this->info('Migrating KaryaSeni thumbnails...');
        
        $karya = KaryaSeni::whereNotNull('thumbnail')
            ->where('thumbnail', 'like', 'storage/%')
            ->get();
        $count = 0;

        foreach ($karya as $item) {
            $oldPath = $item->thumbnail;
            $newPath = str_replace('storage/', '', $oldPath);
            
            $this->line("  KaryaSeni ID {$item->id}: {$oldPath} → {$newPath}");
            
            if (!$dryRun) {
                $item->update(['thumbnail' => $newPath]);
                $count++;
            }
        }

        $this->info("  Updated {$count} KaryaSeni thumbnails.");
        $this->line('');
    }

    /**
     * Migrate SliderImage files
     */
    protected function migrateSliderImages($dryRun)
    {
        $this->info('Migrating SliderImage files...');
        
        $sliders = SliderImage::where('file_path', 'like', 'storage/%')->get();
        $count = 0;

        foreach ($sliders as $item) {
            $oldPath = $item->file_path;
            $newPath = str_replace('storage/', '', $oldPath);
            
            $this->line("  SliderImage ID {$item->id}: {$oldPath} → {$newPath}");
            
            if (!$dryRun) {
                $item->update(['file_path' => $newPath]);
                $count++;
            }
        }

        $this->info("  Updated {$count} SliderImage paths.");
        $this->line('');
    }

    /**
     * Migrate SambutanContent images
     */
    protected function migrateSambutanContent($dryRun)
    {
        $this->info('Migrating SambutanContent images...');
        
        $sambutan = SambutanContent::first();
        if (!$sambutan) {
            $this->info("  No SambutanContent found.");
            return;
        }

        $fields = [
            'hero_image',
            'visi_image',
            'misi_image',
            'obj1_image',
            'obj2_image',
            'obj3_image',
            'obj4_image',
        ];

        $updates = [];
        foreach ($fields as $field) {
            if ($sambutan->$field && strpos($sambutan->$field, 'storage/') === 0) {
                $oldPath = $sambutan->$field;
                $newPath = str_replace('storage/', '', $oldPath);
                
                $this->line("  {$field}: {$oldPath} → {$newPath}");
                $updates[$field] = $newPath;
            }
        }

        if (!empty($updates)) {
            if (!$dryRun) {
                $sambutan->update($updates);
            }
            $this->info("  Updated " . count($updates) . " SambutanContent image paths.");
        } else {
            $this->info("  No SambutanContent paths to update.");
        }

        $this->line('');
    }
}
