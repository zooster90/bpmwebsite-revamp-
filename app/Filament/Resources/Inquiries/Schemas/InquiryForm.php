<?php

namespace App\Filament\Resources\Inquiries\Schemas;

use App\Filament\Components\QuickGuide;
use Filament\Forms\Components\Placeholder;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

/**
 * Inquiry Form — READ ONLY VIEW of a customer's message.
 * Staff can update the status to track follow-up progress.
 */
class InquiryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                QuickGuide::make('Customer Enquiries', [
                    ['icon' => '👁️', 'title' => 'Read the Message',         'tip' => 'All fields on this page are read-only. They show exactly what the customer submitted from the Contact Us page on the website.'],
                    ['icon' => '📞', 'title' => 'Follow Up with Customer',  'tip' => 'Contact the customer using the email address or phone number shown. You can reply directly to their email address.'],
                    ['icon' => '🔄', 'title' => 'Update the Status',        'tip' => 'Change the status on the right to track your follow-up. Use "In Progress" while handling, and "Resolved" once done.'],
                    ['icon' => '🗂️', 'title' => 'Archive When Done',        'tip' => 'Set status to "Archived" to move completed enquiries out of your active list without deleting them.'],
                ], 'You cannot edit the customer\'s message content — it is kept as-is for accurate records.'),

                \Filament\Schemas\Components\Grid::make(12)
                    ->columnSpanFull()
                    ->schema([
                        \Filament\Schemas\Components\Group::make()
                            ->schema([
                                Section::make('Customer Message')
                                    ->description('This is a message received from the Contact Us page on the website.')
                                    ->columns(2)
                                    ->schema([
                                        TextInput::make('name')
                                            ->label('Customer Name')
                                            ->helperText('The name of the person who sent this message.')
                                            ->disabled()
                                            ->dehydrated(false),

                                        TextInput::make('email')
                                            ->label('Email Address')
                                            ->helperText('Click the email to reply directly to this customer.')
                                            ->disabled()
                                            ->dehydrated(false),

                                        TextInput::make('phone')
                                            ->label('Phone Number')
                                            ->helperText('The customer\'s phone number, if provided.')
                                            ->disabled()
                                            ->dehydrated(false),

                                        TextInput::make('subject')
                                            ->label('Subject')
                                            ->helperText('What topic did the customer enquire about?')
                                            ->disabled()
                                            ->dehydrated(false),

                                        Textarea::make('message')
                                            ->label('Full Message')
                                            ->helperText('The full message written by the customer.')
                                            ->rows(6)
                                            ->disabled()
                                            ->dehydrated(false)
                                            ->columnSpanFull(),
                                    ]),
                            ])
                            ->columnSpan(['default' => 12, 'lg' => 8]),

                        \Filament\Schemas\Components\Group::make()
                            ->schema([
                                Section::make('Follow-up Status')
                                    ->description('Update the status to track whether this enquiry has been responded to.')
                                    ->schema([
                                        Select::make('status')
                                            ->label('Current Status')
                                            ->helperText('
                                                New = Just received, not yet read.
                                                In Progress = You are currently handling this.
                                                Resolved = Done — this enquiry has been answered.
                                                Archived = Stored for record keeping only.
                                            ')
                                            ->options([
                                                'New'         => 'New — Not yet read',
                                                'In Progress' => 'In Progress — Being handled',
                                                'Resolved'    => 'Resolved — Enquiry answered',
                                                'Archived'    => 'Archived — Record only',
                                            ])
                                            ->required()
                                            ->default('New'),
                                    ]),
                            ])
                            ->columnSpan(['default' => 12, 'lg' => 4]),
                    ]),
            ]);
    }
}
