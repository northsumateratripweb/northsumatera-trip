<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AdminLogResource\Pages;
use App\Models\AdminLog;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class AdminLogResource extends Resource
{
    protected static ?string $model = AdminLog::class;

    protected static ?string $navigationIcon = 'heroicon-o-finger-print';
    protected static ?string $navigationGroup = 'Pengaturan';
    protected static ?int $navigationSort = 2;
    protected static ?string $navigationLabel = 'Log Aktivitas';

    public static function form(Form $form): Form
    {
        return $form->schema([]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Waktu')
                    ->dateTime('d M Y H:i')
                    ->sortable(),
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Admin')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('action')
                    ->label('Aksi')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('description')
                    ->label('Deskripsi')
                    ->wrap()
                    ->limit(80),
                Tables\Columns\TextColumn::make('ip_address')
                    ->label('IP')
                    ->toggleable(),
            ])
            ->filters([])
            ->actions([])
            ->bulkActions([]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAdminLogs::route('/'),
        ];
    }

    public static function canAccess(): bool
    {
        $user = auth()->user();
        if (! $user) {
            return false;
        }

        $role = $user->role ?? 'super_admin';

        return $role === 'super_admin';
    }
}

