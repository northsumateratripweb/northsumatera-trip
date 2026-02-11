<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TripDataResource\Pages;
use App\Models\TripData;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class TripDataResource extends Resource
{
    protected static ?string $model = TripData::class;

    protected static ?string $navigationIcon = 'heroicon-o-calendar-days';
    protected static ?string $navigationLabel = 'Data Trip';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Informasi Trip')
                    ->schema([
                        DatePicker::make('tanggal')
                            ->label('Tanggal')
                            ->required()
                            ->default(now()),
                        TextInput::make('nama_pelanggan')
                            ->label('Nama Pelanggan')
                            ->required()
                            ->maxLength(255),
                        Select::make('status')
                            ->label('Status')
                            ->options([
                                'pending' => 'Pending',
                                'confirmed' => 'Confirmed',
                                'ongoing' => 'Ongoing',
                                'completed' => 'Completed',
                                'cancelled' => 'Cancelled',
                            ])
                            ->default('pending')
                            ->required(),
                        TextInput::make('nomor_hp')
                            ->label('Nomor HP')
                            ->tel()
                            ->required()
                            ->maxLength(255),
                    ])
                    ->columns(2),

                Section::make('Driver & Layanan')
                    ->schema([
                        TextInput::make('nama_driver')
                            ->label('Nama Driver')
                            ->maxLength(255),
                        Select::make('layanan')
                            ->label('Layanan')
                            ->options([
                                'Tour' => 'Tour',
                                'Car Rental' => 'Car Rental',
                                'Tour + Car Rental' => 'Tour + Car Rental',
                                'Custom Package' => 'Custom Package',
                            ])
                            ->required(),
                        TextInput::make('plat_mobil')
                            ->label('Plat Mobil')
                            ->maxLength(20),
                        Select::make('jenis_mobil')
                            ->label('Jenis Mobil')
                            ->options([
                                'Avanza' => 'Avanza',
                                'Innova' => 'Innova',
                                'Alphard' => 'Alphard',
                                'Hiace' => 'Hiace',
                                'Bus' => 'Bus',
                                'Lainnya' => 'Lainnya',
                            ]),
                        Toggle::make('drone')
                            ->label('Drone')
                            ->default(false),
                    ])
                    ->columns(3),

                Section::make('Detail Perjalanan')
                    ->schema([
                        TextInput::make('jumlah_hari')
                            ->label('Jumlah Hari')
                            ->numeric()
                            ->default(1)
                            ->required(),
                        TextInput::make('penumpang')
                            ->label('Penumpang')
                            ->numeric()
                            ->default(1)
                            ->required(),
                        TextInput::make('hotel_1')
                            ->label('Hotel 1')
                            ->maxLength(255),
                        TextInput::make('hotel_2')
                            ->label('Hotel 2')
                            ->maxLength(255),
                        TextInput::make('hotel_3')
                            ->label('Hotel 3')
                            ->maxLength(255),
                        TextInput::make('hotel_4')
                            ->label('Hotel 4')
                            ->maxLength(255),
                    ])
                    ->columns(3),

                Section::make('Keuangan')
                    ->schema([
                        TextInput::make('harga')
                            ->label('Harga')
                            ->numeric()
                            ->prefix('Rp')
                            ->default(0),
                        TextInput::make('deposit')
                            ->label('Deposit')
                            ->numeric()
                            ->prefix('Rp')
                            ->default(0),
                        TextInput::make('pelunasan')
                            ->label('Pelunasan')
                            ->numeric()
                            ->prefix('Rp')
                            ->default(0),
                    ])
                    ->columns(3),

                Section::make('Informasi Tambahan')
                    ->schema([
                        DatePicker::make('tiba')
                            ->label('Tiba'),
                        TextInput::make('flight_balik')
                            ->label('Flight Balik')
                            ->maxLength(255),
                        Textarea::make('notes')
                            ->label('Catatan')
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
                TextColumn::make('tanggal')
                    ->label('Tanggal')
                    ->date('d M Y')
                    ->sortable(),
                TextColumn::make('nama_pelanggan')
                    ->label('Nama Pelanggan')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'pending' => 'warning',
                        'confirmed' => 'info',
                        'ongoing' => 'success',
                        'completed' => 'success',
                        'cancelled' => 'danger',
                        default => 'gray',
                    }),
                TextColumn::make('nomor_hp')
                    ->label('Nomor HP')
                    ->searchable(),
                TextColumn::make('layanan')
                    ->label('Layanan')
                    ->searchable(),
                TextColumn::make('harga')
                    ->label('Harga')
                    ->money('idr', true)
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->label('Status')
                    ->options([
                        'pending' => 'Pending',
                        'confirmed' => 'Confirmed',
                        'ongoing' => 'Ongoing',
                        'completed' => 'Completed',
                        'cancelled' => 'Cancelled',
                    ]),
                SelectFilter::make('layanan')
                    ->label('Layanan')
                    ->options([
                        'Tour' => 'Tour',
                        'Car Rental' => 'Car Rental',
                        'Tour + Car Rental' => 'Tour + Car Rental',
                        'Custom Package' => 'Custom Package',
                    ]),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('tanggal', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTripData::route('/'),
            'create' => Pages\CreateTripData::route('/create'),
            'view' => Pages\ViewTripData::route('/{record}'),
            'edit' => Pages\EditTripData::route('/{record}/edit'),
        ];
    }
}
