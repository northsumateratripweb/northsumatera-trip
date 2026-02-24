<?php

namespace App\Filament\Resources;

use App\Filament\Resources\GalleryResource\Pages;
use App\Models\Gallery;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;

class GalleryResource extends Resource
{
    protected static ?string $model = Gallery::class;

    protected static ?string $navigationIcon = 'heroicon-o-photo';
    protected static ?string $navigationGroup = 'Katalog';
    protected static ?int $navigationSort = 3;
    protected static ?string $navigationLabel = 'Galeri Foto';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Informasi Galeri')
                    ->schema([
                        TextInput::make('title')
                            ->label('Judul')
                            ->maxLength(255),
                        TextInput::make('category')
                            ->label('Kategori')
                            ->maxLength(255)
                            ->placeholder('Contoh: Danau Toba, Medan City Tour'),
                        TextInput::make('image_url')
                            ->label('URL Gambar')
                            ->url()
                            ->required()
                            ->placeholder('https://example.com/image.jpg')
                            ->helperText('Masukkan URL lengkap gambar yang ingin ditambahkan')
                            ->maxLength(500),
                        Textarea::make('description')
                            ->label('Deskripsi')
                            ->rows(3)
                            ->maxLength(1000),
                        TextInput::make('order')
                            ->label('Urutan')
                            ->numeric()
                            ->default(0)
                            ->helperText('Angka lebih kecil akan muncul lebih dulu'),
                        Toggle::make('is_active')
                            ->label('Aktif')
                            ->default(true),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('image_url')
                    ->label('Gambar')
                    ->circular()
                    ->size(60),
                TextColumn::make('title')
                    ->label('Judul')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('category')
                    ->label('Kategori')
                    ->searchable(),
                TextColumn::make('order')
                    ->label('Urutan')
                    ->sortable(),
                ToggleColumn::make('is_active')
                    ->label('Aktif'),
                TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('Status Aktif'),
                Tables\Filters\SelectFilter::make('category')
                    ->label('Kategori')
                    ->options(fn () => \App\Models\Gallery::query()
                        ->select('category')
                        ->whereNotNull('category')
                        ->distinct()
                        ->orderBy('category')
                        ->pluck('category', 'category')
                        ->toArray()),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('order', 'asc');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListGalleries::route('/'),
            'create' => Pages\CreateGallery::route('/create'),
            'edit' => Pages\EditGallery::route('/{record}/edit'),
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
