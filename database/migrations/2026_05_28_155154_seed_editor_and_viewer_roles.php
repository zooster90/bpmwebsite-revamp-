<?php

use Illuminate\Database\Migrations\Migration;
use Spatie\Permission\Models\Role;

/**
 * Seed Editor + Viewer roles idempotently. Used a migration instead of a
 * standalone seeder so the roles appear automatically on every deploy
 * without anyone needing to remember to run `db:seed`.
 *
 * - Super Admin → unrestricted (created by DatabaseSeeder)
 * - Editor      → can create/edit content, can't manage users or settings
 * - Viewer      → read-only access
 */
return new class extends Migration
{
    public function up(): void
    {
        Role::firstOrCreate(['name' => 'Super Admin', 'guard_name' => 'web']);
        Role::firstOrCreate(['name' => 'Editor',      'guard_name' => 'web']);
        Role::firstOrCreate(['name' => 'Viewer',      'guard_name' => 'web']);
    }

    public function down(): void
    {
        // Intentionally a no-op. Removing roles would orphan user assignments.
    }
};
