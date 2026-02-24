<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TourResource\Pages;
use App\Models\Tour;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class TourResource extends Resource
{
    protected static ?string $model = Tour::class;

    protected static ?string $navigationIcon  = 'heroicon-o-globe-alt';
    protected static ?string $navigationGroup = 'Katalog';
    protected static ?int    $navigationSort  = 1;
    protected static ?string $navigationLabel = 'Paket Wisata';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Informasi Utama')
                ->schema([
                    TextInput::make('title')
                        ->label('Nama Paket Wisata')
                        ->required(),
                    TextInput::make('slug')
                        ->label('Slug URL')
                        ->required()
                        ->unique(Tour::class, 'slug', ignoreRecord: true),
                    TextInput::make('price')
                        ->label('Harga Paket (Default)')
                        ->numeric()
                        ->prefix('Rp')
                        ->required(),
                    TextInput::make('location')
                        ->label('Lokasi Destinasi')
                        ->required(),
                    TextInput::make('duration_days')
                        ->label('Durasi Perjalanan (Hari)')
                        ->numeric()
                        ->required(),
                ])
                ->columns(2),

            Forms\Components\Section::make('Detail & Media')
                ->schema([
                    FileUpload::make('thumbnail')
                        ->label('Foto Utama Paket')
                        ->image()
                        ->directory('tours')
                        ->required(),
                    FileUpload::make('trip_image')
                        ->label('Foto Keterangan Trip')
                        ->image()
                        ->directory('tours')
                        ->nullable(),
                    RichEditor::make('description')
                        ->label('Deskripsi Wisata')
                        ->required()
                        ->columnSpanFull(),
                    RichEditor::make('itinerary')
                        ->label('Itinerari Perjalanan')
                        ->required()
                        ->columnSpanFull(),
                    TextInput::make('itinerary_url')
                        ->label('Link Google Drive Itinerary')
                        ->placeholder('https://drive.google.com/...')
                        ->url()
                        ->columnSpanFull(),
                ]),

            Forms\Components\Section::make('Paket Trip (A-H) & Harga')
                ->description('Kelola pilihan tipe trip dengan harga masing-masing')
                ->schema([
                    Repeater::make('trips')
                        ->label('Pilihan Trip')
                        ->schema([
                            Select::make('trip_key')
                                ->label('Tipe Trip')
                                ->options([
                                    'a' => 'Trip A - Basic',
                                    'b' => 'Trip B - Standar',
                                    'c' => 'Trip C - Premium',
                                    'd' => 'Trip D - Deluxe',
                                    'e' => 'Trip E - VIP',
                                    'f' => 'Trip F - Luxury',
                                    'g' => 'Trip G - Premium Luxury',
                                    'h' => 'Trip H - Ultra VIP',
                                ])
                                ->required(),
                            TextInput::make('name')
                                ->label('Nama Paket')
                                ->placeholder('Contoh: Basic, Standard, Premium')
                                ->required(),
                            TextInput::make('price')
                                ->label('Harga per Orang')
                                ->numeric()
                                ->prefix('Rp')
                                ->required(),
                            TextInput::make('includes')
                                ->label('Apa yang Termasuk')
                                ->placeholder('Contoh: Hotel + Meals + Guide + Activities')
                                ->columnSpanFull(),
                        ])
                        ->columns(3)
                        ->addActionLabel('Tambah Tipe Trip')
                        ->collapsible()
                        ->columnSpanFull(),
                ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->label('Nama Paket')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('location')
                    ->label('Lokasi')
                    ->sortable(),
                Tables\Columns\TextColumn::make('price')
                    ->label('Harga')
                    ->money('idr', true),
            ])
            ->filters([
                //
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
            'index' => Pages\ListTours::route('/'),
            'create' => Pages\CreateTour::route('/create'),
            'edit' => Pages\EditTour::route('/{record}/edit'),
        ];
    }

    public static function canAccess(): bool
    {
        $user = auth()->user();
        if (! $user) {
            return false;
        }

        $role = $user->role ?? 'super_admin';

        return in_array($role, ['super_admin', 'marketing']);
    }
}
