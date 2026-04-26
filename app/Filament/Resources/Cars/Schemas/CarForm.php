<?php

namespace App\Filament\Resources\Cars\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class CarForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([

                // ── BASIC INFO ───────────────────────────────────────────────
                Section::make('Informasi Dasar')
                    ->description('Detail utama listing yang terlihat oleh pelanggan')
                    ->icon('heroicon-o-identification')
                    ->schema([
                        TextInput::make('title')
                            ->label('Judul Listing')
                            ->placeholder('cth., Toyota Avanza 1.5 Veloz AT 2022')
                            ->helperText('Dibuat otomatis jika dikosongkan: Tahun Merek Model Varian')
                            ->maxLength(255)
                            ->columnSpanFull(),

                        Select::make('make')
                            ->label('Merek')
                            ->required()
                            ->searchable()
                            ->options([
                                'BMW'           => 'BMW',
                                'BYD'           => 'BYD',
                                'Chevrolet'     => 'Chevrolet',
                                'Daihatsu'      => 'Daihatsu',
                                'DFSK'          => 'DFSK',
                                'Ford'          => 'Ford',
                                'Honda'         => 'Honda',
                                'Hyundai'       => 'Hyundai',
                                'Isuzu'         => 'Isuzu',
                                'Kia'           => 'Kia',
                                'Mazda'         => 'Mazda',
                                'Mercedes-Benz' => 'Mercedes-Benz',
                                'Mitsubishi'    => 'Mitsubishi',
                                'Nissan'        => 'Nissan',
                                'Subaru'        => 'Subaru',
                                'Suzuki'        => 'Suzuki',
                                'Toyota'        => 'Toyota',
                                'Volkswagen'    => 'Volkswagen',
                                'Wuling'        => 'Wuling',
                            ]),

                        TextInput::make('model')
                            ->label('Model')
                            ->required()
                            ->placeholder('cth., Avanza, Civic, Rush')
                            ->maxLength(255),

                        TextInput::make('variant')
                            ->label('Varian / Tipe')
                            ->placeholder('cth., GR Sport, Limited, 1.5 AT')
                            ->maxLength(255),

                        TextInput::make('year')
                            ->label('Tahun')
                            ->required()
                            ->numeric()
                            ->minValue(1990)
                            ->maxValue(date('Y') + 1)
                            ->default(date('Y')),
                    ])
                    ->columns(2),

                // ── SPECIFICATIONS ────────────────────────────────────────────
                Section::make('Spesifikasi')
                    ->description('Detail teknis kendaraan')
                    ->icon('heroicon-o-cog-6-tooth')
                    ->schema([
                        TextInput::make('mileage_km')
                            ->label('Kilometer')
                            ->required()
                            ->numeric()
                            ->minValue(0)
                            ->suffix('km')
                            ->placeholder('cth., 45000'),

                        Select::make('transmission')
                            ->label('Transmisi')
                            ->required()
                            ->options([
                                'automatic' => 'Otomatis',
                                'manual'    => 'Manual',
                            ]),

                        Select::make('fuel_type')
                            ->label('Bahan Bakar')
                            ->required()
                            ->options([
                                'bensin'   => 'Bensin (Gasoline)',
                                'diesel'   => 'Diesel',
                                'hybrid'   => 'Hybrid',
                                'electric' => 'Electric',
                            ]),

                        Select::make('body_type')
                            ->label('Tipe Bodi')
                            ->required()
                            ->options([
                                'suv'         => 'SUV',
                                'mpv'         => 'MPV',
                                'sedan'       => 'Sedan',
                                'hatchback'   => 'Hatchback',
                                'pickup'      => 'Pickup Truck',
                                'van'         => 'Van',
                                'coupe'       => 'Coupe',
                                'convertible' => 'Convertible',
                                'wagon'       => 'Wagon',
                            ]),

                        TextInput::make('color')
                            ->label('Warna Eksterior')
                            ->required()
                            ->placeholder('cth., Putih Mutiara, Hitam')
                            ->maxLength(100),

                        TextInput::make('seats')
                            ->label('Kapasitas Kursi')
                            ->numeric()
                            ->minValue(2)
                            ->maxValue(20)
                            ->suffix('kursi')
                            ->placeholder('cth., 5 atau 7'),
                    ])
                    ->columns(3),

                // ── PRICING & LOCATION ────────────────────────────────────────
                Section::make('Harga & Lokasi')
                    ->description('Tentukan harga jual dan cabang dealer')
                    ->icon('heroicon-o-banknotes')
                    ->schema([
                        TextInput::make('price')
                            ->label('Harga Jual')
                            ->required()
                            ->numeric()
                            ->prefix('Rp')
                            ->minValue(0)
                            ->placeholder('cth., 285000000')
                            ->helperText('Masukkan harga penuh dalam Rupiah — tanpa titik atau koma'),

                        Select::make('location_id')
                            ->label('Cabang / Lokasi')
                            ->relationship('location', 'name')
                            ->searchable()
                            ->preload()
                            ->createOptionForm([
                                TextInput::make('name')->required()->maxLength(255),
                                TextInput::make('city')->maxLength(100),
                                TextInput::make('address')->maxLength(255),
                            ])
                            ->helperText('Cabang mana yang memiliki mobil ini?'),
                    ])
                    ->columns(2),

                // ── VEHICLE DOCUMENTATION ─────────────────────────────────────
                Section::make('Dokumen Kendaraan')
                    ->description('Detail legalitas dan registrasi')
                    ->icon('heroicon-o-document-text')
                    ->schema([
                        TextInput::make('vin')
                            ->label('VIN / Nomor Rangka')
                            ->placeholder('cth., MHRRD18501J007654')
                            ->unique(ignoreRecord: true)
                            ->maxLength(255),

                        Select::make('plate_parity')
                            ->label('Ganjil / Genap')
                            ->options([
                                'ganjil' => 'Ganjil',
                                'genap'  => 'Genap',
                            ])
                            ->helperText('Sistem pembatasan kendaraan berdasarkan plat nomor'),

                        DatePicker::make('stnk_valid_until')
                            ->label('STNK Berlaku Hingga')
                            ->displayFormat('d M Y')
                            ->helperText('Tanggal kadaluarsa STNK kendaraan'),
                    ])
                    ->columns(3),

                // ── DESCRIPTION & FEATURES ────────────────────────────────────
                Section::make('Deskripsi & Fitur')
                    ->description('Keunggulan dan detail tambahan mobil ini')
                    ->icon('heroicon-o-list-bullet')
                    ->schema([
                        Textarea::make('description')
                            ->label('Deskripsi')
                            ->rows(5)
                            ->maxLength(5000)
                            ->placeholder('Jelaskan kondisi, riwayat, dan modifikasi kendaraan...')
                            ->columnSpanFull(),

                        TagsInput::make('features')
                            ->label('Fitur & Kelengkapan')
                            ->placeholder('Ketik fitur lalu tekan Enter')
                            ->helperText('cth., Sunroof, Kamera 360, Android Auto, Jok Kulit, ABS, Dual Airbag')
                            ->columnSpanFull(),
                    ]),

                // ── STATUS & VISIBILITY ───────────────────────────────────────
                Section::make('Status & Visibilitas')
                    ->description('Atur bagaimana dan di mana listing ini ditampilkan')
                    ->icon('heroicon-o-eye')
                    ->schema([
                        Toggle::make('featured')
                            ->label('Tampilkan di Homepage')
                            ->helperText('Ditampilkan di hero carousel dan grid unggulan')
                            ->default(false),

                        Toggle::make('sold')
                            ->label('Tandai Sebagai Terjual')
                            ->helperText('Menyembunyikan mobil dari inventaris publik')
                            ->default(false),

                        DatePicker::make('sold_at')
                            ->label('Tanggal Terjual')
                            ->displayFormat('d M Y')
                            ->helperText('Diisi otomatis saat mobil ditandai terjual; bisa disesuaikan untuk laporan dashboard.'),
                    ])
                    ->columns(2),

                Section::make('Foto Mobil')
                    ->description('Upload foto awal saat membuat listing baru')
                    ->icon('heroicon-o-photo')
                    ->visibleOn('create')
                    ->schema([
                        FileUpload::make('initial_images')
                            ->label('Foto')
                            ->default([])
                            ->image()
                            ->multiple()
                            ->reorderable()
                            ->appendFiles()
                            ->maxFiles(13)
                            ->maxParallelUploads(13)
                            ->panelLayout('grid')
                            ->disk('public_root')
                            ->directory('images/cars')
                            ->visibility('public')
                            ->maxSize(5120)
                            ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])
                            ->helperText('Bisa upload sampai 13 foto sekaligus. Foto pertama akan dijadikan foto utama, lalu urutan dan foto utama bisa diatur lagi setelah listing dibuat.')
                            ->columnSpanFull(),
                    ]),

            ]);
    }
}
