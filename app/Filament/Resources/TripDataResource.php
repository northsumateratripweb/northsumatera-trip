<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TripDataResource\Pages;
use App\Models\AdminLog;
use App\Models\TripData;
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

    protected static ?string $navigationIcon  = 'heroicon-o-map-pin';
    protected static ?string $navigationGroup = 'Operasional';
    protected static ?int    $navigationSort  = 2;
    protected static ?string $navigationLabel = 'Jadwal Trip';
    protected static ?string $modelLabel       = 'Data Trip';
    protected static ?string $pluralModelLabel = 'Data Trip';

    // ── Shared option lists (matching Excel validation data) ──────────

    private static function statusOptions(): array
    {
        return [
            'Sudah Booking'    => 'Sudah Booking',
            'Sedang berjalan'  => 'Sedang berjalan',
            'Selesai'          => 'Selesai',
            'Cancelled'        => 'Cancelled',
        ];
    }

    private static function layananOptions(): array
    {
        return [
            'Paket Trip' => 'Paket Trip',
            'Rent Car'   => 'Rent Car',
        ];
    }

    private static function jenisMobilOptions(): array
    {
        return [
            'Avanza'        => 'Avanza',
            'Innova'        => 'Innova',
            'Hiace'         => 'Hiace',
            'Commuter'      => 'Commuter',
            'Hiace Premio'  => 'Hiace Premio',
            'ELF'           => 'ELF',
            'Alphard'       => 'Alphard',
            'Bus'           => 'Bus',
            'Bus Medium'    => 'Bus Medium',
        ];
    }

    private static function hotelOptions(): array
    {
        // Load all active hotels from DB, grouped by location
        $hotels = \App\Models\Hotel::where('is_active', true)
            ->orderBy('location')
            ->orderBy('name')
            ->get();

        $options = [];
        foreach ($hotels as $hotel) {
            $group = $hotel->location ?? 'Lainnya';
            $options[$group][$hotel->name] = $hotel->name;
        }

        // Flatten to include group labels for searchable select
        $flat = [];
        foreach ($options as $group => $items) {
            foreach ($items as $k => $v) {
                $flat[$k] = "[$group] $v";
            }
        }

        return $flat;
    }

    // ── FORM ──────────────────────────────────────────────────────────

    public static function form(Form $form): Form
    {
        return $form
            ->schema([

                // ── 1. Informasi Trip ────────────────────────────────
                Section::make('📋 Informasi Trip')
                    ->schema([
                        DatePicker::make('tanggal')
                            ->label('Tanggal Keberangkatan')
                            ->required()
                            ->default(now())
                            ->displayFormat('d/m/Y'),

                        TextInput::make('nama_pelanggan')
                            ->label('Nama Pelanggan')
                            ->required()
                            ->maxLength(255),

                        Select::make('status')
                            ->label('Status')
                            ->options(self::statusOptions())
                            ->default('Sudah Booking')
                            ->required()
                            ->native(false),

                        TextInput::make('nomor_hp')
                            ->label('Nomor HP')
                            ->tel()
                            ->required()
                            ->maxLength(50),
                    ])
                    ->columns(2),

                // ── 2. Driver & Kendaraan ────────────────────────────
                Section::make('🚗 Driver & Kendaraan')
                    ->schema([
                        TextInput::make('nama_driver')
                            ->label('Nama Driver')
                            ->maxLength(255),

                        Select::make('layanan')
                            ->label('Layanan')
                            ->options(self::layananOptions())
                            ->required()
                            ->native(false),

                        TextInput::make('plat_mobil')
                            ->label('Plat Mobil')
                            ->maxLength(20)
                            ->placeholder('BK 1234 AB'),

                        Select::make('jenis_mobil')
                            ->label('Jenis Mobil')
                            ->options(self::jenisMobilOptions())
                            ->searchable()
                            ->native(false),

                        Toggle::make('drone')
                            ->label('Pakai Drone? 🚁')
                            ->default(false)
                            ->inline(false),
                    ])
                    ->columns(3),

                // ── 3. Detail Perjalanan ─────────────────────────────
                Section::make('🗺️ Detail Perjalanan')
                    ->schema([
                        TextInput::make('jumlah_hari')
                            ->label('Jumlah Hari')
                            ->numeric()
                            ->default(1)
                            ->minValue(1)
                            ->required(),

                        TextInput::make('penumpang')
                            ->label('Jumlah Penumpang')
                            ->numeric()
                            ->default(1)
                            ->minValue(1)
                            ->required(),

                        Select::make('hotel_1')
                            ->label('Hotel 1')
                            ->options(self::hotelOptions())
                            ->searchable()
                            ->native(false)
                            ->createOptionForm([
                                TextInput::make('name')
                                    ->label('Nama Hotel Baru')
                                    ->required(),
                                Select::make('location')
                                    ->label('Lokasi')
                                    ->options([
                                        'Danau Toba' => 'Danau Toba',
                                        'Berastagi'  => 'Berastagi',
                                        'Medan'      => 'Medan',
                                        'Lainnya'    => 'Lainnya',
                                    ])
                                    ->native(false),
                            ])
                            ->createOptionUsing(function (array $data): string {
                                $hotel = \App\Models\Hotel::firstOrCreate(
                                    ['name' => $data['name']],
                                    ['location' => $data['location'] ?? null, 'is_active' => true]
                                );
                                return $hotel->name;
                            }),

                        Select::make('hotel_2')
                            ->label('Hotel 2')
                            ->options(self::hotelOptions())
                            ->searchable()
                            ->native(false)
                            ->createOptionForm([
                                TextInput::make('name')
                                    ->label('Nama Hotel Baru')
                                    ->required(),
                                Select::make('location')
                                    ->label('Lokasi')
                                    ->options([
                                        'Danau Toba' => 'Danau Toba',
                                        'Berastagi'  => 'Berastagi',
                                        'Medan'      => 'Medan',
                                        'Lainnya'    => 'Lainnya',
                                    ])
                                    ->native(false),
                            ])
                            ->createOptionUsing(function (array $data): string {
                                $hotel = \App\Models\Hotel::firstOrCreate(
                                    ['name' => $data['name']],
                                    ['location' => $data['location'] ?? null, 'is_active' => true]
                                );
                                return $hotel->name;
                            }),

                        Select::make('hotel_3')
                            ->label('Hotel 3')
                            ->options(self::hotelOptions())
                            ->searchable()
                            ->native(false)
                            ->createOptionForm([
                                TextInput::make('name')
                                    ->label('Nama Hotel Baru')
                                    ->required(),
                                Select::make('location')
                                    ->label('Lokasi')
                                    ->options([
                                        'Danau Toba' => 'Danau Toba',
                                        'Berastagi'  => 'Berastagi',
                                        'Medan'      => 'Medan',
                                        'Lainnya'    => 'Lainnya',
                                    ])
                                    ->native(false),
                            ])
                            ->createOptionUsing(function (array $data): string {
                                $hotel = \App\Models\Hotel::firstOrCreate(
                                    ['name' => $data['name']],
                                    ['location' => $data['location'] ?? null, 'is_active' => true]
                                );
                                return $hotel->name;
                            }),

                        Select::make('hotel_4')
                            ->label('Hotel 4')
                            ->options(self::hotelOptions())
                            ->searchable()
                            ->native(false)
                            ->createOptionForm([
                                TextInput::make('name')
                                    ->label('Nama Hotel Baru')
                                    ->required(),
                                Select::make('location')
                                    ->label('Lokasi')
                                    ->options([
                                        'Danau Toba' => 'Danau Toba',
                                        'Berastagi'  => 'Berastagi',
                                        'Medan'      => 'Medan',
                                        'Lainnya'    => 'Lainnya',
                                    ])
                                    ->native(false),
                            ])
                            ->createOptionUsing(function (array $data): string {
                                $hotel = \App\Models\Hotel::firstOrCreate(
                                    ['name' => $data['name']],
                                    ['location' => $data['location'] ?? null, 'is_active' => true]
                                );
                                return $hotel->name;
                            }),
                    ])
                    ->columns(3),

                // ── 4. Keuangan ──────────────────────────────────────
                Section::make('💰 Keuangan')
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

                // ── 5. Informasi Tambahan ────────────────────────────
                Section::make('✈️ Informasi Tambahan')
                    ->schema([
                        DatePicker::make('tiba')
                            ->label('Tanggal Tiba / Pulang')
                            ->displayFormat('d/m/Y'),

                        TextInput::make('flight_balik')
                            ->label('Flight Balik')
                            ->maxLength(255)
                            ->placeholder('Contoh: GA-181 Medan-Jakarta 18:30'),

                        Textarea::make('notes')
                            ->label('Catatan Tambahan')
                            ->rows(3)
                            ->columnSpanFull()
                            ->placeholder('Catatan khusus, permintaan, hotel alternatif, dll.'),
                    ])
                    ->columns(2),
            ]);
    }

    // ── TABLE ─────────────────────────────────────────────────────────

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
                    ->sortable()
                    ->weight('bold'),

                Tables\Columns\SelectColumn::make('status')
                    ->label('Status')
                    ->options(self::statusOptions())
                    ->sortable(),

                TextColumn::make('nomor_hp')
                    ->label('Nomor HP')
                    ->searchable()
                    ->toggleable(),

                TextColumn::make('nama_driver')
                    ->label('Driver')
                    ->searchable()
                    ->toggleable(),

                TextColumn::make('layanan')
                    ->label('Layanan')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Paket Trip' => 'info',
                        'Rent Car'   => 'success',
                        default      => 'gray',
                    }),

                TextColumn::make('jenis_mobil')
                    ->label('Jenis Mobil')
                    ->toggleable(),

                Tables\Columns\IconColumn::make('drone')
                    ->label('Drone')
                    ->boolean()
                    ->toggleable(),

                TextColumn::make('jumlah_hari')
                    ->label('Hari')
                    ->suffix(' hari')
                    ->sortable(),

                TextColumn::make('penumpang')
                    ->label('Penumpang')
                    ->suffix(' org')
                    ->sortable(),

                TextColumn::make('hotel_1')
                    ->label('Hotel 1')
                    ->limit(20)
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('harga')
                    ->label('Harga')
                    ->money('idr', true)
                    ->sortable(),

                TextColumn::make('deposit')
                    ->label('Deposit')
                    ->money('idr', true)
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('pelunasan')
                    ->label('Pelunasan')
                    ->money('idr', true)
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('booking_id')
                    ->label('ID Booking')
                    ->toggleable()
                    ->formatStateUsing(fn ($state) => $state ? '#' . $state : '-'),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->label('Status')
                    ->options(self::statusOptions()),

                SelectFilter::make('layanan')
                    ->label('Layanan')
                    ->options(self::layananOptions()),

                SelectFilter::make('jenis_mobil')
                    ->label('Jenis Mobil')
                    ->options(self::jenisMobilOptions()),
            ])
            ->headerActions([
                Tables\Actions\Action::make('exportCsv')
                    ->label('Export CSV')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->action(function () {
                        return response()->streamDownload(function () {
                            $handle = fopen('php://output', 'w');

                            // Header CSV — sama persis dengan kolom Excel
                            fputcsv($handle, [
                                'Tanggal',
                                'Nama Pelanggan',
                                'Status',
                                'Nomor HP',
                                'Nama Driver',
                                'Layanan',
                                'Plat Mobil',
                                'Jenis Mobil',
                                'Drone',
                                'Jumlah Hari',
                                'Penumpang',
                                'Hotel 1',
                                'Hotel 2',
                                'Hotel 3',
                                'Hotel 4',
                                'Harga',
                                'Deposit',
                                'Pelunasan',
                                'Tiba',
                                'Flight Balik',
                                'Catatan',
                                'ID Booking',
                            ]);

                            TripData::orderBy('tanggal', 'desc')->chunk(200, function ($rows) use ($handle) {
                                foreach ($rows as $row) {
                                    fputcsv($handle, [
                                        optional($row->tanggal)->format('d/m/Y'),
                                        $row->nama_pelanggan,
                                        $row->status,
                                        $row->nomor_hp,
                                        $row->nama_driver,
                                        $row->layanan,
                                        $row->plat_mobil,
                                        $row->jenis_mobil,
                                        $row->drone ? 'Ya' : 'Tidak',
                                        $row->jumlah_hari,
                                        $row->penumpang,
                                        $row->hotel_1,
                                        $row->hotel_2,
                                        $row->hotel_3,
                                        $row->hotel_4,
                                        $row->harga,
                                        $row->deposit,
                                        $row->pelunasan,
                                        optional($row->tiba)->format('d/m/Y'),
                                        $row->flight_balik,
                                        $row->notes,
                                        $row->booking_id ? '#' . $row->booking_id : '',
                                    ]);
                                }
                            });

                            fclose($handle);
                        }, 'trip-data-' . now()->format('Y-m-d-His') . '.csv', [
                            'Content-Type' => 'text/csv',
                        ]);
                    }),
            ])
            ->actions([
                Tables\Actions\Action::make('printPdf')
                    ->label('Cetak PDF')
                    ->icon('heroicon-o-printer')
                    ->color('info')
                    ->url(fn (TripData $record): string => route('trip-data.pdf', $record->id))
                    ->openUrlInNewTab(),

                Tables\Actions\Action::make('viewBooking')
                    ->label('Lihat Pesanan')
                    ->icon('heroicon-o-shopping-cart')
                    ->color('gray')
                    ->visible(fn (TripData $record): bool => filled($record->booking_id))
                    ->url(fn (TripData $record): string => route('filament.admin.resources.bookings.edit', $record->booking_id))
                    ->openUrlInNewTab(),

                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\BulkAction::make('updateStatus')
                        ->label('Update Status Terpilih')
                        ->icon('heroicon-o-check-circle')
                        ->form([
                            Select::make('status')
                                ->label('Pilih Status Baru')
                                ->options(self::statusOptions())
                                ->required(),
                        ])
                        ->action(function (\Illuminate\Database\Eloquent\Collection $records, array $data): void {
                            $records->each(fn ($record) => $record->update(['status' => $data['status']]));

                            AdminLog::create([
                                'user_id'     => optional(auth()->user())->id,
                                'action'      => 'trip_data.bulk_update_status',
                                'description' => 'Mengubah status ' . count($records) . ' trip data menjadi ' . $data['status'],
                                'ip_address'  => request()->ip(),
                                'user_agent'  => request()->userAgent(),
                            ]);
                        })
                        ->deselectRecordsAfterCompletion(),
                ]),
            ])
            ->defaultSort('tanggal', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListTripData::route('/'),
            'create' => Pages\CreateTripData::route('/create'),
            'view'   => Pages\ViewTripData::route('/{record}'),
            'edit'   => Pages\EditTripData::route('/{record}/edit'),
        ];
    }

    public static function getRelations(): array
    {
        return [
            \App\Filament\Resources\TripDataResource\RelationManagers\TripChecklistsRelationManager::class,
        ];
    }
}
