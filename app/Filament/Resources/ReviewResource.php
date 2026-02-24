<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ReviewResource\Pages;
use App\Filament\Resources\ReviewResource\RelationManagers;
use App\Models\Review;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ReviewResource extends Resource
{
    protected static ?string $model = Review::class;

    protected static ?string $navigationIcon = 'heroicon-o-star';
    protected static ?string $navigationGroup = 'Konten';
    protected static ?int $navigationSort = 3;
    protected static ?string $navigationLabel = 'Ulasan / Review';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('tour_id')
                    ->relationship('tour', 'title')
                    ->required(),
                Forms\Components\TextInput::make('customer_name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Select::make('rating')
                    ->options([
                        1 => '1 Bintang',
                        2 => '2 Bintang',
                        3 => '3 Bintang',
                        4 => '4 Bintang',
                        5 => '5 Bintang',
                    ])
                    ->required(),
                Forms\Components\Textarea::make('comment')
                    ->required()
                    ->columnSpanFull(),
                Forms\Components\Toggle::make('is_published')
                    ->label('Tampilkan di Website')
                    ->default(true),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('tour.title')
                    ->label('Paket Wisata')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('customer_name')
                    ->label('Pelanggan')
                    ->searchable(),
                Tables\Columns\TextColumn::make('rating')
                    ->label('Rating')
                    ->sortable(),
                Tables\Columns\IconColumn::make('is_published')
                    ->label('Status')
                    ->boolean(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageReviews::route('/'),
        ];
    }
}
