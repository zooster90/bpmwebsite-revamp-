<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Throwable;

class RemapImportedCultureEventMedia extends Command
{
    protected $signature = 'media:remap-culture-events
        {events_json : Path to the culture_events JSON dump from intern}
        {--min-media-id=2662 : Only remap media rows with id >= this}
        {--dry-run : Show what would change without writing}';

    protected $description = 'Re-link recently imported media to the correct live CultureEvent rows. Matches by title (creates new live rows when no live event has that title).';

    private int $remapped = 0;
    private int $alreadyCorrect = 0;
    private int $inserted = 0;
    private int $orphaned = 0;

    public function handle(): int
    {
        $jsonPath = $this->argument('events_json');
        if (! is_file($jsonPath)) {
            $this->error("File not found: {$jsonPath}");
            return self::INVALID;
        }

        $internRows = json_decode(file_get_contents($jsonPath), true);
        if (! is_array($internRows)) {
            $this->error('JSON malformed.');
            return self::INVALID;
        }

        $dryRun = (bool) $this->option('dry-run');
        if ($dryRun) {
            $this->warn('DRY RUN — no DB writes.');
        }

        $internLookup = [];
        foreach ($internRows as $row) {
            $internLookup[$row['id']] = $row;
        }

        $affectedMedia = DB::table('media')
            ->where('id', '>=', (int) $this->option('min-media-id'))
            ->where('model_type', 'App\\Models\\CultureEvent')
            ->orderBy('id')
            ->get();

        $this->info("Found {$affectedMedia->count()} media rows to inspect.");
        $this->newLine();

        $mappingCache = [];

        foreach ($affectedMedia as $media) {
            $internEvent = $internLookup[$media->model_id] ?? null;
            if (! $internEvent) {
                $this->warn("  media#{$media->id} references intern event#{$media->model_id} not in dump — orphan, skipping.");
                $this->orphaned++;
                continue;
            }

            $internId    = (int) $internEvent['id'];
            $internTitle = trim($internEvent['title'] ?? '');

            if ($internTitle === '') {
                $this->warn("  media#{$media->id} intern event#{$internId} has empty title — skipping.");
                $this->orphaned++;
                continue;
            }

            if (! isset($mappingCache[$internId])) {
                $mappingCache[$internId] = $this->resolveLiveEventId($internEvent, $dryRun);
            }
            $liveId = $mappingCache[$internId];

            if ((int) $media->model_id === $liveId) {
                $this->alreadyCorrect++;
                continue;
            }

            $this->line("  media#{$media->id}: \"{$internTitle}\" — remap model_id {$media->model_id} → {$liveId}");

            if (! $dryRun) {
                DB::table('media')->where('id', $media->id)->update(['model_id' => $liveId]);
            }
            $this->remapped++;
        }

        $this->newLine();
        $this->info("Remapped:        {$this->remapped}");
        $this->info("Already correct: {$this->alreadyCorrect}");
        $this->info("Inserted new:    {$this->inserted}");
        $this->info("Orphaned:        {$this->orphaned}");
        return self::SUCCESS;
    }

    private function resolveLiveEventId(array $internEvent, bool $dryRun): int
    {
        $title = trim($internEvent['title']);

        // Try exact title match first
        $live = DB::table('culture_events')->where('title', $title)->first();
        if ($live) {
            return (int) $live->id;
        }

        // No match — insert intern's event as a new live row
        $columns = [
            'title', 'slug', 'event_date', 'description', 'image_url', 'year',
            'name', 'culture_image_upload', 'gallery_uploads', 'is_published',
            'location', 'intern_name', 'university', 'department', 'intern_period',
            'category_id', 'sub_category_id', 'video_url', 'video_upload',
        ];

        $row = [];
        foreach ($columns as $col) {
            if (array_key_exists($col, $internEvent)) {
                $row[$col] = $internEvent[$col];
            }
        }
        $row['slug'] = $row['slug'] ?: Str::slug($title).'-'.Str::random(5);
        $row['created_at'] = $internEvent['created_at'] ?? now();
        $row['updated_at'] = now();

        if ($dryRun) {
            $this->line("    [would insert] new CultureEvent \"{$title}\"");
            $this->inserted++;
            return -1 * (int) $internEvent['id']; // sentinel, won't be written in dry-run
        }

        // Ensure slug uniqueness in live
        $baseSlug = $row['slug'];
        $attempt = 0;
        while (DB::table('culture_events')->where('slug', $row['slug'])->exists()) {
            $attempt++;
            $row['slug'] = $baseSlug.'-'.$attempt;
            if ($attempt > 10) break;
        }

        $newId = DB::table('culture_events')->insertGetId($row);
        $this->line("    [inserted] new CultureEvent #{$newId} \"{$title}\"");
        $this->inserted++;
        return (int) $newId;
    }
}
