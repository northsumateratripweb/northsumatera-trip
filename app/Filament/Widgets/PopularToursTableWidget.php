<?php

namespace App\Filament\Widgets;

use App\Models\Tour;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class PopularToursTableWidget extends BaseWidget
{
    protected static ?string $heading = 'Daftar Paket Paling Laris';

    protected int|string|array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Tour::query()
                    ->withCount(['bookings' => function ($query) {
                        $query->where('payment_status', 'success');
                    }])
                    ->orderByDesc('bookings_count')
            )
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->label('Nama Paket')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('location')
                    ->label('Lokasi')
                    ->searchable(),
                Tables\Columns\TextColumn::make('bookings_count')
                    ->label('Total Pemesanan')
                    ->counts('bookings')
                    ->sortable()
                    ->badge()
                    ->color('success'),
                Tables\Columns\TextColumn::make('price')
                    ->label('Harga')
                    ->money('idr', true)
                    ->sortable(),
            ])
            ->defaultSort('bookings_count', 'desc');
    }
}
