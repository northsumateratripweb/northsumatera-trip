<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PostResource\Pages;
use App\Models\Post;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class PostResource extends Resource
{
    protected static ?string $model = Post::class;

    protected static ?string $navigationIcon  = 'heroicon-o-newspaper';
    protected static ?string $navigationGroup = 'Konten';
    protected static ?int    $navigationSort  = 1;
    protected static ?string $navigationLabel = 'Artikel / Blog';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Konten Artikel')
                    ->schema([
                        Forms\Components\TextInput::make('title')
                            ->required()
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn ($state, $set) => $set('slug', str()->slug($state))),
                        Forms\Components\TextInput::make('slug')->required()->unique(ignoreRecord: true),
                        Forms\Components\Select::make('category')
                            ->options([
                                'Tips' => 'Tips Wisata',
                                'Kuliner' => 'Kuliner Sumut',
                                'Event' => 'Event Budaya',
                            ])->required(),
                        Forms\Components\FileUpload::make('thumbnail')->image()->directory('blog')->required(),
                        Forms\Components\RichEditor::make('content')->required()->columnSpanFull(),
                        Forms\Components\Toggle::make('is_published')->label('Publikasikan')->default(true),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
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
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPosts::route('/'),
            'create' => Pages\CreatePost::route('/create'),
            'edit' => Pages\EditPost::route('/{record}/edit'),
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
