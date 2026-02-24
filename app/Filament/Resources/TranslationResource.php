<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TranslationResource\Pages;
use App\Models\Translation;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class TranslationResource extends Resource
{
    protected static ?string $model = Translation::class;

    protected static ?string $navigationIcon = 'heroicon-o-language';
    protected static ?string $navigationGroup = 'Pengaturan';
    protected static ?int $navigationSort = 3;
    protected static ?string $navigationLabel = 'Manajemen Bahasa';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Identifikasi Text')
                    ->schema([
                        Forms\Components\TextInput::make('key')
                            ->label('Kode Unik (Key)')
                            ->required()
                            ->regex('/^[a-zA-Z0-9_.]+$/')
                            ->validationMessages([
                                'regex' => 'Key hanya boleh berisi huruf, angka, underscore (_), dan titik (.).',
                            ])
                            ->unique(ignoreRecord: true)
                            ->disabled(fn (?Translation $record) => $record !== null),
                        Forms\Components\Select::make('group')
                            ->label('Grup')
                            ->options([
                                'general' => 'Umum',
                                'home' => 'Halaman Depan',
                                'booking' => 'Booking',
                            ])->default('general'),
                    ])->columns(2),

                Forms\Components\Section::make('Terjemahan Konten')
                    ->schema([
                        Forms\Components\Textarea::make('id_value')->label('Bahasa Indonesia (ID)')->rows(3)->required(),
                        Forms\Components\Textarea::make('en_value')->label('English (EN)')->rows(3)->required(),
                        Forms\Components\Textarea::make('ms_value')->label('Bahasa Malaysia (MS)')->rows(3)->required(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('key')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('id_value')->label('Indonesia')->limit(50),
                Tables\Columns\TextColumn::make('group')->badge(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('group')
                    ->options([
                        'general' => 'Umum',
                        'home' => 'Halaman Depan',
                    ]),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTranslations::route('/'),
            'create' => Pages\CreateTranslation::route('/create'),
            'edit' => Pages\EditTranslation::route('/{record}/edit'),
        ];
    }
}
