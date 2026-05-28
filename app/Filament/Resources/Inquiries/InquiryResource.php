<?php

namespace App\Filament\Resources\Inquiries;

use App\Filament\Resources\Inquiries\Pages\EditInquiry;
use App\Filament\Resources\Inquiries\Pages\ListInquiries;
use App\Filament\Resources\Inquiries\Schemas\InquiryForm;
use App\Filament\Resources\Inquiries\Tables\InquiriesTable;
use App\Models\Inquiry;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class InquiryResource extends Resource
{
    use \App\Filament\Concerns\RoleBasedAccess;

    protected static ?string $model = Inquiry::class;

    protected static ?string $navigationLabel = 'Contact Enquiries';
    protected static string | \UnitEnum | null $navigationGroup = '📩 Inbox';
    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-inbox-arrow-down';
    protected static ?int $navigationSort = 10;

    protected static ?string $modelLabel = 'Enquiry';
    protected static ?string $pluralModelLabel = 'Contact Enquiries';
    protected static ?string $recordTitleAttribute = 'name';

    public static function canCreate(): bool
    {
        return false;
    }

    /**
     * Badge count on sidebar — shows number of new/unread enquiries.
     * This is the red number badge you see next to the menu item.
     */
    public static function getNavigationBadge(): ?string
    {
        $count = static::getModel()::where('status', 'New')->count();
        return $count > 0 ? (string) $count : null;
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return 'warning';
    }

    public static function form(Schema $schema): Schema
    {
        return InquiryForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return InquiriesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index'  => ListInquiries::route('/'),
            'edit'   => EditInquiry::route('/{record}/edit'),
        ];
    }
}
