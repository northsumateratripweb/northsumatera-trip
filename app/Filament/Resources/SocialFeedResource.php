<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SocialFeedResource\Pages;
use App\Filament\Resources\SocialFeedResource\RelationManagers;
use App\Models\SocialFeed;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SocialFeedResource extends Resource
{
    protected static ?string $model = SocialFeed::class;

    protected static ?string $navigationIcon = 'heroicon-o-camera';
    protected static ?string $navigationGroup = 'Marketing';
    protected static ?int $navigationSort = 1;
    protected static ?string $modelLabel = 'Instagram Feed';
    protected static ?string $pluralModelLabel = 'Instagram Feeds';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make()
                    ->schema([
                        Forms\Components\FileUpload::make('image')
                            ->image()
                            ->directory('social-feeds')
                            ->required(),
                        Forms\Components\Textarea::make('caption')
                            ->label('Caption Instagram')
                            ->placeholder('Copy caption dari Instagram di sini...')
                            ->rows(3),
                        Forms\Components\TextInput::make('instagram_url')
                            ->label('Link Post Instagram')
                            ->url()
                            ->placeholder('https://www.instagram.com/p/...'),
                        Forms\Components\Grid::make(2)
                            ->schema([
                                Forms\Components\Toggle::make('is_active')
                                    ->label('Tampilkan')
                                    ->default(true),
                                Forms\Components\TextInput::make('order')
                                    ->label('Urutan')
                                    ->numeric()
                                    ->default(0),
                            ]),
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('image')
                    ->circular(),
                Tables\Columns\TextColumn::make('caption')
                    ->label('Caption')
                    ->limit(50)
                    ->searchable(),
                Tables\Columns\IconColumn::make('is_active')
                    ->label('Aktif')
                    ->boolean(),
                Tables\Columns\TextColumn::make('order')
                    ->label('Urutan')
                    ->sortable(),
            ])
            ->defaultSort('order', 'asc')
            ->filters([
                //
            ])
            ->actions([
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
            'index' => Pages\ListSocialFeeds::route('/'),
            'create' => Pages\CreateSocialFeed::route('/create'),
            'edit' => Pages\EditSocialFeed::route('/{record}/edit'),
        ];
    }
}
