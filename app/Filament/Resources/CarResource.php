<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CarResource\Pages;
use App\Models\Car;
use Filament\Forms;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class CarResource extends Resource
{
    protected static ?string $model = Car::class;

    protected static ?string $navigationIcon  = 'heroicon-o-truck';
    protected static ?string $navigationGroup = 'Pengaturan Aset';
    protected static ?int    $navigationSort  = 2;
    protected static ?string $navigationLabel = 'Armada Kendaraan';
    protected static ?string $modelLabel       = 'Kendaraan';
    protected static ?string $pluralModelLabel = 'Semua Kendaraan';

    private static function jenisMobilOptions(): array
    {
        return [
            'Avanza'        => 'Toyota Avanza',
            'Innova'        => 'Toyota Innova',
            'Hiace'         => 'Toyota Hiace',
            'Commuter'      => 'Toyota Hiace Commuter',
            'Hiace Premio'  => 'Toyota Hiace Premio',
            'ELF'           => 'Isuzu ELF',
            'Alphard'       => 'Toyota Alphard',
            'Bus'           => 'Bus Besar',
            'Bus Medium'    => 'Bus Medium',
        ];
    }

    public static function form(Form $form): Form
    {
        return $form->schema([

            Section::make('🚗 Informasi Kendaraan')
                ->schema([
                    TextInput::make('name')
                        ->label('Nama / Tipe Kendaraan')
                        ->required()
                        ->maxLength(255)
                        ->placeholder('Contoh: Avanza Silver'),

                    Select::make('jenis_mobil')
                        ->label('Jenis Kendaraan')
                        ->options(self::jenisMobilOptions())
                        ->searchable()
                        ->native(false)
                        ->placeholder('Pilih jenis...'),

                    TextInput::make('brand')
                        ->label('Merek')
                        ->maxLength(100)
                        ->placeholder('Contoh: Toyota'),

                    TextInput::make('plat_nomor')
                        ->label('Plat Nomor')
                        ->maxLength(20)
                        ->placeholder('Contoh: BK 1234 AB'),

                    TextInput::make('capacity')
                        ->label('Kapasitas Penumpang')
                        ->numeric()
                        ->suffix('Pax')
                        ->required(),

                    Select::make('transmission')
                        ->label('Transmisi')
                        ->options([
                            'Manual'    => 'Manual',
                            'Automatic' => 'Automatic',
                        ])
                        ->native(false),

                    TextInput::make('price_per_day')
                        ->label('Harga per Hari')
                        ->numeric()
                        ->prefix('Rp')
                        ->required(),

                    Toggle::make('is_available')
                        ->label('Tersedia untuk Booking')
                        ->default(true)
                        ->inline(false),
                ])
                ->columns(2),

            Section::make('📸 Foto & Deskripsi')
                ->schema([
                    Forms\Components\FileUpload::make('thumbnail')
                        ->label('Foto Utama')
                        ->image()
                        ->directory('cars')
                        ->imageResizeMode('cover')
                        ->imageCropAspectRatio('16:9'),

                    Forms\Components\RichEditor::make('description')
                        ->label('Deskripsi Kendaraan')
                        ->columnSpanFull(),
                ])
                ->columns(1),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('thumbnail')
                    ->label('Foto')
                    ->square()
                    ->size(52),

                Tables\Columns\TextColumn::make('name')
                    ->label('Kendaraan')
                    ->searchable()
                    ->sortable()
                    ->weight('bold')
                    ->description(fn (Car $record) => trim(($record->brand ?? '') . ' · ' . ($record->plat_nomor ?? ''))),

                Tables\Columns\TextColumn::make('jenis_mobil')
                    ->label('Jenis')
                    ->badge()
                    ->color('info')
                    ->toggleable(),

                Tables\Columns\TextColumn::make('capacity')
                    ->label('Kapasitas')
                    ->suffix(' Pax')
                    ->sortable(),

                Tables\Columns\TextColumn::make('transmission')
                    ->label('Transmisi')
                    ->badge()
                    ->color(fn ($state) => $state === 'Automatic' ? 'success' : 'gray')
                    ->toggleable(),

                Tables\Columns\TextColumn::make('price_per_day')
                    ->label('Harga/Hari')
                    ->money('idr', true)
                    ->sortable(),

                Tables\Columns\IconColumn::make('is_available')
                    ->label('Tersedia')
                    ->boolean(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('jenis_mobil')
                    ->label('Jenis Kendaraan')
                    ->options(self::jenisMobilOptions()),
                Tables\Filters\TernaryFilter::make('is_available')
                    ->label('Ketersediaan'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\BulkAction::make('setAvailable')
                        ->label('Tandai Tersedia')
                        ->icon('heroicon-o-check-circle')
                        ->color('success')
                        ->action(fn ($records) => $records->each->update(['is_available' => true])),
                    Tables\Actions\BulkAction::make('setUnavailable')
                        ->label('Tandai Tidak Tersedia')
                        ->icon('heroicon-o-x-circle')
                        ->color('danger')
                        ->action(fn ($records) => $records->each->update(['is_available' => false])),
                ]),
            ])
            ->defaultSort('name');
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListCars::route('/'),
            'create' => Pages\CreateCar::route('/create'),
            'edit'   => Pages\EditCar::route('/{record}/edit'),
        ];
    }
}
