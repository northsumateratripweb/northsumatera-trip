<?php

namespace App\Filament\Resources;

use App\Filament\Resources\StaticPageResource\Pages;
use App\Models\StaticPage;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class StaticPageResource extends Resource
{
    protected static ?string $model = StaticPage::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-duplicate';
    protected static ?string $navigationGroup = 'Konten';
    protected static ?int $navigationSort = 2;
    protected static ?string $navigationLabel = 'Halaman Statis';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Halaman')
                    ->schema([
                        Forms\Components\TextInput::make('title')
                            ->label('Judul')
                            ->required()
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn ($state, $set) => $set('slug', str()->slug($state))),
                        Forms\Components\TextInput::make('slug')
                            ->label('Slug')
                            ->required()
                            ->unique(ignoreRecord: true),
                        Forms\Components\RichEditor::make('content')
                            ->label('Konten')
                            ->required()
                            ->columnSpanFull(),
                        Forms\Components\Toggle::make('is_published')
                            ->label('Publikasikan')
                            ->default(true),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->label('Judul')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('slug')
                    ->label('Slug')
                    ->searchable(),
                Tables\Columns\IconColumn::make('is_published')
                    ->label('Publish')
                    ->boolean(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Diubah')
                    ->dateTime('d M Y H:i')
                    ->sortable(),
            ])
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
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListStaticPages::route('/'),
            'create' => Pages\CreateStaticPage::route('/create'),
            'edit' => Pages\EditStaticPage::route('/{record}/edit'),
        ];
    }

    public static function canAccess(): bool
    {
        $user = auth()->user();
        if (! $user) {
            return false;
        }

        $role = $user->role ?? 'super_admin';

        return in_array($role, ['super_admin', 'marketing']);
    }
}
