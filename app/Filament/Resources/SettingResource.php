<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SettingResource\Pages;
use App\Models\Setting;
use Filament\Forms;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class SettingResource extends Resource
{
    protected static ?string $model = Setting::class;

    protected static ?string $navigationIcon = 'heroicon-o-cog-6-tooth';
    protected static ?string $navigationLabel = 'Pengaturan Bisnis';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Informasi Perusahaan')
                    ->schema([
                        TextInput::make('company_name')
                            ->label('Nama Perusahaan')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('whatsapp_number')
                            ->label('Nomor WhatsApp')
                            ->tel()
                            ->placeholder('6282381118520')
                            ->maxLength(255),
                        TextInput::make('email')
                            ->label('Email')
                            ->email()
                            ->maxLength(255),
                    ])
                    ->columns(2),

                Section::make('Media Sosial')
                    ->schema([
                        TextInput::make('instagram_url')
                            ->label('Instagram URL')
                            ->url()
                            ->placeholder('https://instagram.com/username')
                            ->maxLength(255),
                        TextInput::make('tiktok_url')
                            ->label('TikTok URL')
                            ->url()
                            ->placeholder('https://tiktok.com/@username')
                            ->maxLength(255),
                        TextInput::make('facebook_url')
                            ->label('Facebook URL')
                            ->url()
                            ->placeholder('https://facebook.com/username')
                            ->maxLength(255),
                    ])
                    ->columns(3),

                Section::make('Tema & Branding')
                    ->schema([
                        ColorPicker::make('primary_color')
                            ->label('Warna Utama')
                            ->default('#FF4433')
                            ->required(),
                        ColorPicker::make('secondary_color')
                            ->label('Warna Sekunder')
                            ->default('#f53003')
                            ->required(),
                        FileUpload::make('hero_image')
                            ->label('Gambar Hero')
                            ->image()
                            ->directory('settings')
                            ->imageEditor()
                            ->nullable(),
                        FileUpload::make('logo')
                            ->label('Logo Perusahaan')
                            ->image()
                            ->directory('settings')
                            ->imageEditor()
                            ->nullable(),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('company_name')
                    ->label('Nama Perusahaan')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('whatsapp_number')
                    ->label('WhatsApp')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->label('Email')
                    ->searchable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                //
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSettings::route('/'),
            'edit' => Pages\EditSetting::route('/{record}/edit'),
        ];
    }
}
