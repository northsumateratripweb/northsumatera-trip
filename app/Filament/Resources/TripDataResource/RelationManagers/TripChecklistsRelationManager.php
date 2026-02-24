<?php

namespace App\Filament\Resources\TripDataResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class TripChecklistsRelationManager extends RelationManager
{
    protected static string $relationship = 'checklists';

    protected static ?string $title = 'Checklist Operasional';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('item')
                    ->label('Item Checklist')
                    ->required(),
                Forms\Components\Toggle::make('is_done')
                    ->label('Selesai')
                    ->default(false),
                Forms\Components\TextInput::make('order')
                    ->label('Urutan')
                    ->numeric()
                    ->default(0),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\IconColumn::make('is_done')
                    ->label('Selesai')
                    ->boolean(),
                Tables\Columns\TextColumn::make('item')
                    ->label('Item')
                    ->wrap()
                    ->searchable(),
                Tables\Columns\TextColumn::make('order')
                    ->label('Urutan')
                    ->sortable(),
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
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
}

