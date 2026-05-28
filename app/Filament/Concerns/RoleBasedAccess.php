<?php

namespace App\Filament\Concerns;

/**
 * Role-based access control for Filament Resources.
 *
 * Roles seeded by 2026_05_28_155154_seed_editor_and_viewer_roles.php:
 *   - Super Admin → unrestricted (everything)
 *   - Editor      → full CRUD on content, cannot delete records, cannot manage users
 *   - Viewer      → read-only access (list + view records, no create/edit/delete)
 *
 * Apply by adding `use \App\Filament\Concerns\RoleBasedAccess;` inside a
 * Resource class. The User resource gets a stricter override (Super Admin
 * only) directly on its own class.
 *
 * Why static methods: Filament Resources are static and call these to
 * decide whether to show buttons / allow page routes. They run before any
 * record is loaded, so $record may be null on list/create flows.
 */
trait RoleBasedAccess
{
    public static function canViewAny(): bool
    {
        return auth()->user()?->hasAnyRole(['Super Admin', 'Editor', 'Viewer']) ?? false;
    }

    public static function canView($record): bool
    {
        return static::canViewAny();
    }

    public static function canCreate(): bool
    {
        return auth()->user()?->hasAnyRole(['Super Admin', 'Editor']) ?? false;
    }

    public static function canEdit($record): bool
    {
        return auth()->user()?->hasAnyRole(['Super Admin', 'Editor']) ?? false;
    }

    public static function canDelete($record): bool
    {
        return auth()->user()?->hasRole('Super Admin') ?? false;
    }

    public static function canDeleteAny(): bool
    {
        return auth()->user()?->hasRole('Super Admin') ?? false;
    }

    public static function canForceDelete($record): bool
    {
        return auth()->user()?->hasRole('Super Admin') ?? false;
    }

    public static function canForceDeleteAny(): bool
    {
        return auth()->user()?->hasRole('Super Admin') ?? false;
    }

    public static function canRestore($record): bool
    {
        return auth()->user()?->hasRole('Super Admin') ?? false;
    }

    public static function canReorder(): bool
    {
        return auth()->user()?->hasAnyRole(['Super Admin', 'Editor']) ?? false;
    }

    public static function canReplicate($record): bool
    {
        return auth()->user()?->hasAnyRole(['Super Admin', 'Editor']) ?? false;
    }
}
