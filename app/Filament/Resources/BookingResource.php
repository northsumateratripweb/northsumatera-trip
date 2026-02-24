<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BookingResource\Pages;
use App\Filament\Resources\BookingResource\RelationManagers;
use App\Models\Booking;
use App\Models\AdminLog;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class BookingResource extends Resource
{
    protected static ?string $model = Booking::class;

    protected static ?string $navigationIcon  = 'heroicon-o-shopping-bag';
    protected static ?string $navigationGroup = 'Operasional';
    protected static ?int    $navigationSort  = 1;
    protected static ?string $modelLabel        = 'Pesanan';
    protected static ?string $pluralModelLabel  = 'Semua Pesanan';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informasi Pelanggan')
                    ->schema([
                        Forms\Components\TextInput::make('customer_name')
                            ->label('Nama Lengkap')
                            ->required(),
                        Forms\Components\TextInput::make('customer_whatsapp')
                            ->label('WhatsApp')
                            ->required(),
                        Forms\Components\TextInput::make('email')
                            ->email(),
                        Forms\Components\TextInput::make('phone')
                            ->label('Telepon Lainnya')
                            ->tel(),
                    ])->columns(2),

                Forms\Components\Section::make('Detail Pesanan')
                    ->schema([
                        Forms\Components\Select::make('booking_type')
                            ->label('Tipe Pesanan')
                            ->options([
                                'tour' => 'Paket Wisata',
                                'car' => 'Sewa Mobil',
                            ])
                            ->required(),
                        Forms\Components\Select::make('tour_id')
                            ->label('Paket Wisata')
                            ->relationship('tour', 'title')
                            ->searchable()
                            ->preload(),
                        Forms\Components\Select::make('car_id')
                            ->label('Mobil')
                            ->relationship('car', 'name')
                            ->searchable()
                            ->preload(),
                        Forms\Components\DatePicker::make('travel_date')
                            ->label('Tanggal Perjalanan')
                            ->required(),
                        Forms\Components\TextInput::make('qty')
                            ->label('Jumlah Orang/Unit')
                            ->required()
                            ->numeric(),
                        Forms\Components\TextInput::make('duration_days')
                            ->label('Durasi (Hari)')
                            ->numeric(),
                        Forms\Components\TextInput::make('total_price')
                            ->label('Total Harga')
                            ->required()
                            ->numeric()
                            ->prefix('Rp'),
                    ])->columns(2),

                Forms\Components\Section::make('Status & Pembayaran')
                    ->schema([
                        Forms\Components\Select::make('status')
                            ->options([
                                'pending' => 'Pending',
                                'confirmed' => 'Dikonfirmasi',
                                'completed' => 'Selesai',
                                'cancelled' => 'Dibatalkan',
                            ])
                            ->required(),
                        Forms\Components\Select::make('payment_status')
                            ->options([
                                'pending' => 'Belum Bayar',
                                'paid' => 'Sudah Bayar',
                                'expired' => 'Kadaluarsa',
                                'failed' => 'Gagal',
                            ])
                            ->required(),
                        Forms\Components\TextInput::make('external_id')
                            ->label('Order ID / Ref Pembayaran')
                            ->disabled(),
                        Forms\Components\TextInput::make('payment_link')
                            ->label('Link Bukti Pembayaran (Optional)')
                            ->url(),
                        Forms\Components\FileUpload::make('payment_proof')
                            ->label('Bukti Transfer (Upload)')
                            ->directory('payment_proofs')
                            ->image()
                            ->openable()
                            ->downloadable()
                            ->columnSpanFull(),
                    ])->columns(2),

                Forms\Components\Section::make('Informasi Operasional (Verval)')
                    ->description('Data ini biasanya diisi oleh admin/operator setelah pesanan dikonfirmasi.')
                    ->schema([
                        Forms\Components\TextInput::make('nama_driver')
                            ->label('Nama Driver'),
                        Forms\Components\TextInput::make('plat_mobil')
                            ->label('Plat Mobil'),
                        Forms\Components\Select::make('jenis_mobil')
                            ->label('Jenis Mobil')
                            ->options([
                                'Avanza' => 'Avanza',
                                'Innova' => 'Innova',
                                'Hiace' => 'Hiace',
                                'Fortuner' => 'Fortuner',
                                'Bus' => 'Bus',
                            ])->searchable(),
                        
                        Forms\Components\Grid::make(2)
                            ->schema([
                                Forms\Components\Select::make('hotel_1')
                                    ->label('Hotel 1')
                                    ->options(\App\Models\Hotel::all()->pluck('name', 'name'))
                                    ->searchable(),
                                Forms\Components\Select::make('hotel_2')
                                    ->label('Hotel 2')
                                    ->options(\App\Models\Hotel::all()->pluck('name', 'name'))
                                    ->searchable(),
                                Forms\Components\Select::make('hotel_3')
                                    ->label('Hotel 3')
                                    ->options(\App\Models\Hotel::all()->pluck('name', 'name'))
                                    ->searchable(),
                                Forms\Components\Select::make('hotel_4')
                                    ->label('Hotel 4')
                                    ->options(\App\Models\Hotel::all()->pluck('name', 'name'))
                                    ->searchable(),
                            ]),

                        Forms\Components\Grid::make(2)
                            ->schema([
                                Forms\Components\TextInput::make('deposit')
                                    ->label('Deposit')
                                    ->numeric()
                                    ->prefix('Rp'),
                                Forms\Components\TextInput::make('pelunasan')
                                    ->label('Pelunasan')
                                    ->numeric()
                                    ->prefix('Rp'),
                            ]),

                        Forms\Components\DatePicker::make('tiba')
                            ->label('Tanggal Tiba/Selesai'),
                        Forms\Components\TextInput::make('flight_balik')
                            ->label('Flight Balik (Info Penerbangan)'),
                        Forms\Components\Textarea::make('notes')
                            ->label('Catatan/Notes')
                            ->columnSpanFull(),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Tgl Pesan')
                    ->dateTime('d M Y H:i')
                    ->sortable(),
                Tables\Columns\TextColumn::make('customer_name')
                    ->label('Pelanggan')
                    ->searchable()
                    ->description(fn (Booking $record): string => $record->customer_whatsapp),
                Tables\Columns\TextColumn::make('booking_type')
                    ->label('Tipe')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'tour' => 'info',
                        'car' => 'warning',
                        'online' => 'success',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'tour' => 'Tour',
                        'car' => 'Mobil',
                        'online' => 'Online',
                        default => $state,
                    }),
                Tables\Columns\TextColumn::make('item_name')
                    ->label('Item')
                    ->state(function (Booking $record): string {
                        if ($record->booking_type === 'tour') {
                            return $record->tour?->title ?? '-';
                        }
                        return $record->car?->name ?? '-';
                    }),
                Tables\Columns\TextColumn::make('travel_date')
                    ->label('Tgl Trip')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('total_price')
                    ->label('Total')
                    ->money('IDR')
                    ->sortable(),
                Tables\Columns\ImageColumn::make('payment_proof')
                    ->label('Bukti')
                    ->circular()
                    ->placeholder('Belum ada')
                    ->openable(),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn (?string $state): string => match ($state) {
                        'pending' => 'gray',
                        'confirmed' => 'info',
                        'completed' => 'success',
                        'cancelled' => 'danger',
                        default => 'gray',
                    }),
                Tables\Columns\TextColumn::make('payment_status')
                    ->label('Bayar')
                    ->badge()
                    ->color(fn (?string $state): string => match ($state) {
                        'pending' => 'warning',
                        'paid' => 'success',
                        'expired', 'failed' => 'danger',
                        default => 'gray',
                    }),
                Tables\Columns\TextColumn::make('trip_type')
                    ->label('Tipe Trip')
                    ->badge()
                    ->color('info')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('external_id')
                    ->label('ID Transaksi')
                    ->toggleable()
                    ->extraAttributes(['class' => 'whitespace-nowrap']),
                Tables\Columns\TextColumn::make('hotel_1')
                    ->label('Hotel 1')
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('nama_driver')
                    ->label('Driver')
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('plat_mobil')
                    ->label('Plat')
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('booking_type')
                    ->label('Tipe Pesanan')
                    ->options([
                        'tour' => 'Paket Wisata',
                        'car' => 'Sewa Mobil',
                    ]),
                SelectFilter::make('payment_status')
                    ->label('Status Pembayaran')
                    ->options([
                        'pending' => 'Belum Bayar',
                        'paid' => 'Sudah Bayar',
                        'expired' => 'Kadaluarsa',
                        'failed' => 'Gagal',
                    ]),
            ])
            ->headerActions([
                Tables\Actions\Action::make('exportCsv')
                    ->label('Export CSV')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->color('gray')
                    ->action(function () {
                        return response()->streamDownload(function () {
                            $handle = fopen('php://output', 'w');

                            fputcsv($handle, [
                                'Tgl Pesan',
                                'Pelanggan',
                                'WhatsApp',
                                'Tipe',
                                'Item',
                                'Tgl Trip',
                                'Total',
                                'Status',
                                'Status Pembayaran',
                                'External ID',
                            ]);

                            \App\Models\Booking::orderBy('created_at', 'desc')->chunk(200, function ($rows) use ($handle) {
                                foreach ($rows as $row) {
                                    fputcsv($handle, [
                                        optional($row->created_at)->format('Y-m-d H:i'),
                                        $row->customer_name,
                                        $row->customer_whatsapp,
                                        $row->booking_type,
                                        $row->booking_type === 'tour'
                                            ? optional($row->tour)->title
                                            : optional($row->car)->name,
                                        optional($row->travel_date)->format('Y-m-d'),
                                        $row->total_price,
                                        $row->status,
                                        $row->payment_status,
                                        $row->external_id,
                                    ]);
                                }
                            });

                            fclose($handle);
                        }, 'bookings-'.now()->format('Y-m-d-His').'.csv', [
                            'Content-Type' => 'text/csv',
                        ]);
                    }),
            ])
            ->actions([
                Tables\Actions\Action::make('viewInvoice')
                    ->label('Invoice')
                    ->icon('heroicon-o-document-text')
                    ->color('info')
                    ->url(fn (Booking $record): string => route('invoice.show', $record->id))
                    ->openUrlInNewTab(),
                Tables\Actions\Action::make('downloadPdf')
                    ->label('PDF')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->color('gray')
                    ->url(fn (Booking $record): string => route('invoice.pdf', $record->id))
                    ->openUrlInNewTab(),
                Tables\Actions\Action::make('verifyPayment')
                    ->label('Verifikasi Bayar')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->requiresConfirmation()
                    ->visible(fn (Booking $record): bool => $record->payment_status === 'pending')
                    ->action(function (Booking $record): void {
                        $record->update([
                            'payment_status' => 'paid',
                            'status' => 'confirmed',
                        ]);

                        // Sync tripData status
                        if ($record->tripData) {
                            $record->tripData->update([
                                'status' => 'Sudah Booking',
                            ]);
                        }

                        AdminLog::create([
                            'user_id'    => optional(auth()->user())->id,
                            'action'     => 'bookings.verify_payment',
                            'description'=> 'Verifikasi manual pembayaran untuk booking '.$record->id.' menjadi paid',
                            'ip_address' => request()->ip(),
                            'user_agent' => request()->userAgent(),
                        ]);

                        \Filament\Notifications\Notification::make()
                            ->title('Pembayaran diverifikasi')
                            ->success()
                            ->send();
                    }),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBookings::route('/'),
            'create' => Pages\CreateBooking::route('/create'),
            'edit' => Pages\EditBooking::route('/{record}/edit'),
        ];
    }
}
