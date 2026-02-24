<?php

namespace App\Filament\Resources;

use App\Filament\Resources\HotelResource\Pages;
use App\Models\Hotel;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;

class HotelResource extends Resource
{
    protected static ?string $model = Hotel::class;

    protected static ?string $navigationIcon  = 'heroicon-o-building-office-2';
    protected static ?string $navigationGroup = 'Pengaturan Aset';
    protected static ?int    $navigationSort  = 1;
    protected static ?string $navigationLabel = 'Daftar Hotel';
    protected static ?string $modelLabel       = 'Hotel';
    protected static ?string $pluralModelLabel = 'Semua Hotel';

    public static function form(Form $form): Form
    {
        return $form->schema([

            Section::make('🏨 Informasi Hotel')
                ->schema([
                    TextInput::make('name')
                        ->label('Nama Hotel')
                        ->required()
                        ->maxLength(255)
                        ->placeholder('Contoh: Samosir Villa'),

                    Select::make('location')
                        ->label('Lokasi / Daerah')
                        ->options([
                            'Danau Toba'    => 'Danau Toba',
                            'Berastagi'     => 'Berastagi',
                            'Medan'         => 'Medan',
                            'Parapat'       => 'Parapat',
                            'Bukit Lawang'  => 'Bukit Lawang',
                            'Nias'          => 'Nias',
                            'Lainnya'       => 'Lainnya',
                        ])
                        ->searchable()
                        ->createOptionForm([
                            TextInput::make('location')
                                ->label('Nama Lokasi Baru')
                                ->required(),
                        ])
                        ->native(false),

                    Select::make('category')
                        ->label('Kategori / Kelas Hotel')
                        ->options([
                            'Budget'   => '⭐ Budget',
                            'Mid'      => '⭐⭐ Mid-Range',
                            'Premium'  => '⭐⭐⭐ Premium',
                            'Resort'   => '🌿 Resort',
                            'Glamping' => '⛺ Glamping',
                        ])
                        ->native(false),

                    Toggle::make('is_active')
                        ->label('Aktif (tampil di dropdown)')
                        ->default(true)
                        ->inline(false),
                ])
                ->columns(2),

            Section::make('📞 Kontak & Detail')
                ->schema([
                    TextInput::make('phone')
                        ->label('Nomor Telepon Hotel')
                        ->tel()
                        ->maxLength(50),

                    TextInput::make('address')
                        ->label('Alamat')
                        ->maxLength(255),

                    Textarea::make('notes')
                        ->label('Catatan (harga, fasilitas, dll.)')
                        ->rows(3)
                        ->columnSpanFull(),
                ])
                ->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Nama Hotel')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),

                TextColumn::make('location')
                    ->label('Lokasi')
                    ->badge()
                    ->color('info')
                    ->sortable(),

                TextColumn::make('category')
                    ->label('Kategori')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Budget'   => 'gray',
                        'Mid'      => 'info',
                        'Premium'  => 'warning',
                        'Resort'   => 'success',
                        'Glamping' => 'purple',
                        default    => 'gray',
                    }),

                TextColumn::make('phone')
                    ->label('Telepon')
                    ->searchable()
                    ->toggleable(),

                TextColumn::make('notes')
                    ->label('Catatan')
                    ->limit(40)
                    ->toggleable(isToggledHiddenByDefault: true),

                IconColumn::make('is_active')
                    ->label('Aktif')
                    ->boolean(),
            ])
            ->filters([
                SelectFilter::make('location')
                    ->label('Lokasi')
                    ->options([
                        'Danau Toba'   => 'Danau Toba',
                        'Berastagi'    => 'Berastagi',
                        'Medan'        => 'Medan',
                        'Parapat'      => 'Parapat',
                        'Bukit Lawang' => 'Bukit Lawang',
                        'Nias'         => 'Nias',
                        'Lainnya'      => 'Lainnya',
                    ]),

                SelectFilter::make('category')
                    ->label('Kategori')
                    ->options([
                        'Budget'   => 'Budget',
                        'Mid'      => 'Mid-Range',
                        'Premium'  => 'Premium',
                        'Resort'   => 'Resort',
                        'Glamping' => 'Glamping',
                    ]),

                TernaryFilter::make('is_active')
                    ->label('Status Aktif'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\BulkAction::make('activate')
                        ->label('Aktifkan Terpilih')
                        ->icon('heroicon-o-check-circle')
                        ->action(fn ($records) => $records->each->update(['is_active' => true]))
                        ->color('success'),
                    Tables\Actions\BulkAction::make('deactivate')
                        ->label('Nonaktifkan Terpilih')
                        ->icon('heroicon-o-x-circle')
                        ->action(fn ($records) => $records->each->update(['is_active' => false]))
                        ->color('danger'),
                ]),
            ])
            ->defaultSort('location')
            ->reorderable('id');
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListHotels::route('/'),
            'create' => Pages\CreateHotel::route('/create'),
            'edit'   => Pages\EditHotel::route('/{record}/edit'),
        ];
    }
}
