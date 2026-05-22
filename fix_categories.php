<?php
/**
 * Category Cleanup Script
 * ========================
 * Run: php fix_categories.php
 *
 * What this does:
 *  1. Renames all raw-slug categories to proper human-readable names
 *  2. Merges 'training' (ID:63, top-level) into 'work' (ID:52) — same concept
 *  3. Merges 'sponsor' (ID:76) top-level events into 'event' (ID:79)
 *  4. Removes all 'all' sub-categories (they serve no purpose)
 *  5. Removes orphan/junk sub-categories with 0 events attached
 */

require __DIR__ . '/vendor/autoload.php';
$app = require __DIR__ . '/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\Category;
use App\Models\CultureEvent;
use Illuminate\Support\Facades\DB;

// ─────────────────────────────────────────────────────────────────
// STEP 1: Rename top-level categories to human-readable names
// ─────────────────────────────────────────────────────────────────
$renames = [
    42 => ['name' => 'Team Building',       'slug' => 'tb'],
    44 => ['name' => 'Festive Celebrations', 'slug' => 'festive'],
    47 => ['name' => 'Internship',           'slug' => 'intern'],
    52 => ['name' => 'Training & Work',      'slug' => 'work'],
    58 => ['name' => 'CSR Activities',       'slug' => 'csr'],
    40 => ['name' => 'Company Trips',        'slug' => 'trip'],
    79 => ['name' => 'Events & Sponsorship', 'slug' => 'event'],
    76 => ['name' => 'Events & Sponsorship', 'slug' => 'event'], // will be merged below
    63 => ['name' => 'Training & Work',      'slug' => 'work'],  // will be merged below
];

echo "=== STEP 1: Renaming top-level categories ===\n";
foreach ([42, 44, 47, 52, 58, 40, 79] as $id) {
    $cat = Category::find($id);
    if ($cat) {
        $old = $cat->name;
        $cat->update(['name' => $renames[$id]['name'], 'slug' => $renames[$id]['slug']]);
        echo "  Renamed ID:{$id} '{$old}' → '{$renames[$id]['name']}'\n";
    }
}

// ─────────────────────────────────────────────────────────────────
// STEP 2: Rename sub-categories to proper human-readable names
// ─────────────────────────────────────────────────────────────────
echo "\n=== STEP 2: Renaming sub-categories ===\n";
$subRenames = [
    41 => 'Company Trip',
    43 => null,          // delete 'all' sub-cat of tb
    70 => 'Team Building Activity',
    49 => null,          // delete 'all' sub-cat of festive
    45 => 'Annual Dinner',
    56 => 'Birthday Celebration',
    65 => 'Christmas',
    46 => 'Chinese New Year (CNY)',
    51 => 'Dumpling Festival',
    60 => 'Durian Party',
    54 => 'Mid-Autumn Festival',
    55 => 'Others',
    66 => 'Hari Raya',
    61 => 'Winter Solstice',
    48 => 'Internship Programme',
    50 => null,          // delete 'all' sub-cat of intern
    78 => 'Industrial Training',
    53 => null,          // delete 'all' sub-cat of work
    73 => 'Annual Dinner',
    75 => 'Safety Audit',
    57 => 'Award Ceremony',
    71 => 'Company Dinner',
    74 => 'Internship Training',
    69 => 'Others',
    62 => 'Sports & Recreation',
    67 => 'Talk & Sharing Session',
    68 => 'Internal Training',
    59 => 'Charity & Donation',
    72 => null,          // delete 'all' sub-cat of training
    64 => 'Internal Training',
    77 => 'Sponsorship',
    80 => 'Sponsorship Event',
];

foreach ($subRenames as $id => $newName) {
    $cat = Category::find($id);
    if (!$cat) continue;

    if ($newName === null) {
        // Delete 'all' sub-categories — they are junk
        $affected = CultureEvent::where('sub_category_id', $id)->count();
        if ($affected > 0) {
            CultureEvent::where('sub_category_id', $id)->update(['sub_category_id' => null]);
            echo "  Cleared {$affected} events from 'all' sub-cat ID:{$id}, set sub_category_id to null\n";
        }
        $cat->delete();
        echo "  Deleted junk 'all' sub-cat ID:{$id}\n";
    } else {
        $old = $cat->name;
        $cat->update(['name' => $newName]);
        echo "  Renamed sub-cat ID:{$id} '{$old}' → '{$newName}'\n";
    }
}

// ─────────────────────────────────────────────────────────────────
// STEP 3: Merge 'training' (ID:63) top-level into 'work' (ID:52)
// ─────────────────────────────────────────────────────────────────
echo "\n=== STEP 3: Merging 'training' (ID:63) into 'Training & Work' (ID:52) ===\n";
$trainingCat = Category::find(63);
if ($trainingCat) {
    $moved = CultureEvent::where('category_id', 63)->update(['category_id' => 52]);
    echo "  Moved {$moved} events from category_id:63 → 52\n";

    // Move children of 63 under 52
    $childMoved = Category::where('parent_id', 63)->update(['parent_id' => 52]);
    echo "  Moved {$childMoved} sub-categories from parent_id:63 → 52\n";

    $trainingCat->delete();
    echo "  Deleted duplicate top-level 'training' category (ID:63)\n";
}

// ─────────────────────────────────────────────────────────────────
// STEP 4: Merge 'sponsor' (ID:76) top-level into 'event' (ID:79)
// ─────────────────────────────────────────────────────────────────
echo "\n=== STEP 4: Merging 'sponsor' (ID:76) into 'Events & Sponsorship' (ID:79) ===\n";
$sponsorCat = Category::find(76);
if ($sponsorCat) {
    $moved = CultureEvent::where('category_id', 76)->update(['category_id' => 79]);
    echo "  Moved {$moved} events from category_id:76 → 79\n";

    $childMoved = Category::where('parent_id', 76)->update(['parent_id' => 79]);
    echo "  Moved {$childMoved} sub-categories from parent_id:76 → 79\n";

    $sponsorCat->delete();
    echo "  Deleted duplicate 'sponsor' category (ID:76)\n";
}

// ─────────────────────────────────────────────────────────────────
// STEP 5: Final verification
// ─────────────────────────────────────────────────────────────────
echo "\n=== FINAL: Remaining CultureEvent categories ===\n";
$remaining = Category::where('model_type', 'CultureEvent')
    ->orderBy('parent_id')
    ->orderBy('name')
    ->get();

foreach ($remaining as $c) {
    $count = CultureEvent::where('category_id', $c->id)->count();
    $subCount = CultureEvent::where('sub_category_id', $c->id)->count();
    $level = $c->parent_id ? "  └─ (sub of #{$c->parent_id})" : "(TOP LEVEL)";
    echo "  ID:{$c->id} | '{$c->name}' | slug:'{$c->slug}' | {$level} | events:{$count} | as_subcat:{$subCount}\n";
}

echo "\n✅ Category cleanup complete!\n";
