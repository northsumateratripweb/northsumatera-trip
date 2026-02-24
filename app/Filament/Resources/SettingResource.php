<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SettingResource\Pages;
use App\Models\Setting;
use Filament\Forms;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class SettingResource extends Resource
{
    protected static ?string $model = Setting::class;

    protected static ?string $navigationIcon = 'heroicon-o-identification';
    protected static ?string $navigationGroup = 'Pengaturan';
    protected static ?int $navigationSort = 1;
    protected static ?string $navigationLabel = 'Profil Bisnis';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Tabs::make('Settings')
                    ->tabs([
                        Forms\Components\Tabs\Tab::make('Informasi Bisnis')
                            ->icon('heroicon-m-building-office')
                            ->schema([
                                Section::make('Profil Perusahaan')
                                    ->schema([
                                        TextInput::make('company_name')
                                            ->label('Nama Perusahaan')
                                            ->required()
                                            ->maxLength(255),
                                        TextInput::make('whatsapp_number')
                                            ->label('Nomor WhatsApp')
                                            ->tel()
                                            ->placeholder('6282381118520')
                                            ->required(),
                                        TextInput::make('email')
                                            ->label('Email Bisnis')
                                            ->email()
                                            ->required(),
                                        Forms\Components\Textarea::make('address')
                                            ->label('Alamat Kantor')
                                            ->rows(2)
                                            ->columnSpanFull(),
                                    ])->columns(2),

                                Section::make('Jam Operasional & Waktu')
                                    ->schema([
                                        TextInput::make('business_hours')
                                            ->label('Jam Kerja (e.g. 08:00 - 17:00)')
                                            ->placeholder('Senin - Minggu: 24 Jam'),
                                        Select::make('timezone')
                                            ->options([
                                                'Asia/Jakarta' => 'WIB (Asia/Jakarta)',
                                                'Asia/Makassar' => 'WITA (Asia/Makassar)',
                                                'Asia/Jayapura' => 'WIT (Asia/Jayapura)',
                                            ])->default('Asia/Jakarta'),
                                    ])->columns(2),
                            ]),

                        Forms\Components\Tabs\Tab::make('Media Sosial')
                            ->icon('heroicon-m-share')
                            ->schema([
                                Section::make('Link Platform')
                                    ->description('Masukkan URL lengkap akun media sosial Anda')
                                    ->schema([
                                        TextInput::make('facebook_url')->label('Facebook')->url()->placeholder('https://facebook.com/...'),
                                        TextInput::make('instagram_url')->label('Instagram')->url()->placeholder('https://instagram.com/...'),
                                        TextInput::make('tiktok_url')->label('TikTok')->url()->placeholder('https://tiktok.com/...'),
                                        TextInput::make('youtube_url')->label('YouTube')->url()->placeholder('https://youtube.com/...'),
                                        TextInput::make('twitter_url')->label('Twitter / X')->url()->placeholder('https://twitter.com/...'),
                                    ])->columns(2),
                            ]),

                        Forms\Components\Tabs\Tab::make('Branding & UI')
                            ->icon('heroicon-m-paint-brush')
                            ->schema([
                                Section::make('Logo & Favicon')
                                    ->schema([
                                        FileUpload::make('logo')
                                            ->label('Logo Website')
                                            ->directory('settings')
                                            ->image(),
                                        FileUpload::make('favicon')
                                            ->label('Favicon (32x32)')
                                            ->directory('settings')
                                            ->image(),
                                        FileUpload::make('hero_image')
                                            ->label('Default Hero Image')
                                            ->directory('settings')
                                            ->image(),
                                    ])->columns(3),
                                Section::make('Warna Tema')
                                    ->schema([
                                        ColorPicker::make('primary_color')->label('Warna Utama')->default('#FF4433'),
                                        ColorPicker::make('secondary_color')->label('Warna Sekunder')->default('#f53003'),
                                    ])->columns(2),
                            ]),

                        Forms\Components\Tabs\Tab::make('SEO & Analytics')
                            ->icon('heroicon-m-magnifying-glass')
                            ->schema([
                                Section::make('Meta Tags')
                                    ->schema([
                                        TextInput::make('meta_title')->label('Meta Title')->columnSpanFull(),
                                        Forms\Components\Textarea::make('meta_description')->label('Meta Description')->rows(3)->columnSpanFull(),
                                        TextInput::make('meta_keywords')->label('Meta Keywords (pisahkan dengan koma)')->columnSpanFull(),
                                    ]),
                                Section::make('Scripts')
                                    ->schema([
                                        Forms\Components\Textarea::make('google_analytics_id')->label('Google Analytics ID / Tag')->rows(2),
                                    ]),
                            ]),

                        Forms\Components\Tabs\Tab::make('Integrasi & Pembayaran')
                            ->icon('heroicon-m-key')
                            ->schema([
                                Section::make('Rekening Bank & Pembayaran Manual')
                                    ->description('Detail rekening yang akan ditampilkan kepada pelanggan untuk transfer bank manual.')
                                    ->schema([
                                        TextInput::make('bank_name_1')->label('Nama Bank 1')->placeholder('Mandiri'),
                                        TextInput::make('bank_account_1')->label('Nomor Rekening 1')->placeholder('1070014838637'),
                                        TextInput::make('bank_holder_1')->label('Atas Nama 1')->placeholder('Ridho Pasia'),
                                        
                                        Forms\Components\Grid::make(1)->schema([]), // Spacer

                                        TextInput::make('bank_name_2')->label('Nama Bank 2')->placeholder('BCA'),
                                        TextInput::make('bank_account_2')->label('Nomor Rekening 2')->placeholder('8000490520'),
                                        TextInput::make('bank_holder_2')->label('Atas Nama 2')->placeholder('Ridho Pasia'),

                                        FileUpload::make('qris_image')
                                            ->label('Gambar QRIS')
                                            ->directory('settings')
                                            ->image()
                                            ->columnSpanFull(),
                                    ])->columns(3),
                                Section::make('Email Configuration (SMTP)')
                                    ->schema([
                                        TextInput::make('mail_host')->label('Mail Host'),
                                        TextInput::make('mail_port')->label('Mail Port'),
                                        TextInput::make('mail_username')->label('Mail Username'),
                                        TextInput::make('mail_password')->label('Mail Password')->password(),
                                    ])->columns(2),
                            ]),

                        Forms\Components\Tabs\Tab::make('Konten Landing Page')
                            ->icon('heroicon-m-window')
                            ->schema([
                                Section::make('Hero Section')
                                    ->schema([
                                        TextInput::make('hero_badge')->label('Badge Text (atas judul)')->placeholder('The Best Travel Partner 2026'),
                                        TextInput::make('hero_title')->label('Judul Utama (Hero Title)')->placeholder('Jelajahi Sumatera Utara Tanpa Batas'),
                                        Forms\Components\Textarea::make('hero_subtitle')->label('Sub-judul (Hero Subtitle)')->rows(3)->placeholder('Solusi perjalanan wisata profesional untuk Danau Toba, Berastagi, Bukit Lawang, dan sekitarnya.'),
                                    ]),
                                Section::make('CTA Section (Bawah)')
                                    ->schema([
                                        TextInput::make('cta_title')->label('Judul CTA')->placeholder('Siap Menjelajahi Sumatera Utara?'),
                                        Forms\Components\Textarea::make('cta_subtitle')->label('Sub-judul CTA')->rows(3)->placeholder('Konsultasikan rencana perjalanan Anda secara gratis bersama tim profesional kami.'),
                                        TextInput::make('cta_button_text')->label('Teks Tombol CTA')->placeholder('Konsultasi Gratis'),
                                    ]),
                            ]),
                    ])->columnSpanFull(),
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
                    ->icon('heroicon-m-chat-bubble-left-right'),
                Tables\Columns\TextColumn::make('email')
                    ->label('Email'),
                Tables\Columns\TextColumn::make('timezone')
                    ->label('Zona Waktu')
                    ->toggleable(isToggledHiddenByDefault: true),
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
