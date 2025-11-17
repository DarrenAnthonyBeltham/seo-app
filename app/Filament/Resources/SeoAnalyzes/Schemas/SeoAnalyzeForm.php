<?php

namespace App\Filament\Resources\SeoAnalyzes\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;

class SeoAnalyzeForm
{
    /**
     * Extract Google Drive ID from URL
     */
    private static function extractGoogleDriveId(?string $url): ?string
    {
        if (empty($url)) {
            return null;
        }

        // Pattern: https://drive.google.com/file/d/{ID}/view
        if (preg_match('/drive\.google\.com\/file\/d\/([a-zA-Z0-9_-]+)/', $url, $matches)) {
            return $matches[1];
        }

        // Pattern: https://drive.google.com/drive/folders/{ID}
        if (preg_match('/drive\.google\.com\/drive\/(?:u\/\d+\/)?folders\/([a-zA-Z0-9_-]+)/', $url, $matches)) {
            return $matches[1];
        }

        // Pattern: query parameter ?id={ID}
        $parsedUrl = parse_url($url);
        if (!empty($parsedUrl['query'])) {
            parse_str($parsedUrl['query'], $queryParams);
            if (!empty($queryParams['id'])) {
                return $queryParams['id'];
            }
        }

        return null;
    }

    /**
     * Create an ID input field with Google Drive ID extraction
     */
    private static function makeIdInput(string $name, string $label): TextInput
    {
        return TextInput::make($name)
            ->label($label)
            ->maxLength(255)
            ->placeholder('Masukkan ID atau URL Google Drive')
            ->disabled()
            ->dehydrated(true)
            ->live(onBlur: true)
            ->afterStateUpdated(function (Set $set, ?string $state) use ($name) {
                $extractedId = self::extractGoogleDriveId($state);

                if ($extractedId === null) {
                    return;
                }

                if ($extractedId !== $state) {
                    $set($name, $extractedId);
                }
            });
    }

    /**
     * Create a textarea that can automatically sync Google Drive ID to a target field
     */
    private static function makeDriveAwareTextarea(string $name, string $label, string $targetIdField): Textarea
    {
        return Textarea::make($name)
            ->label($label)
            ->rows(4)
            ->autosize()
            ->live(onBlur: true)
            ->afterStateUpdated(function (Set $set, ?string $state) use ($targetIdField) {
                $extractedId = self::extractGoogleDriveId($state);

                if ($extractedId === null) {
                    return;
                }

                $set($targetIdField, $extractedId);
            });
    }

    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components([
                Section::make('Basic Information')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                Select::make('status')
                                    ->options([
                                        'mulai analisa' => 'Mulai Analisa',
                                        'daftar kompetitor telah dibuat' => 'Daftar Kompetitor Telah Dibuat',
                                        'mulai analisa ke 2' => 'Mulai Analisa Ke 2',
                                        'generate to pdf' => 'Generate to PDF',
                                        'pdf generated' => 'PDF Generated',
                                    ])
                                    ->default('mulai analisa ke 2')
                                    ->required()
                                    ->columnSpan(1),
                                TextInput::make('kata_kunci_utama')
                                    ->label('Kata Kunci Utama')
                                    ->maxLength(255)
                                    ->columnSpan(1),
                            ]),
                        Grid::make(2)
                            ->schema([
                                TextInput::make('target_url')
                                    ->label('Target URL')
                                    ->url()
                                    ->maxLength(255)
                                    ->columnSpan(1),
                                TextInput::make('konteks_lokal_negara')
                                    ->label('Konteks Lokal Negara')
                                    ->maxLength(255)
                                    ->columnSpan(1),
                            ]),
                        TextInput::make('url_analisa')
                            ->label('URL Analisa')
                            ->url()
                            ->maxLength(255)
                            ->disabled()
                            ->dehydrated(true)
                            ->hint('Nilai diatur otomatis, tidak dapat diedit.'),
                    ])
                    ->collapsible()
                    ->persistCollapsed()
                    ->id('basic-information'),

                Section::make('SERP & Competitor Data')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextInput::make('kata_kunci_serp_kompetitor')
                                    ->label('Kata Kunci SERP Kompetitor')
                                    ->maxLength(255)
                                    ->live(onBlur: true)
                                    ->afterStateUpdated(function (Set $set, ?string $state) {
                                        $extractedId = self::extractGoogleDriveId($state);

                                        if ($extractedId === null) {
                                            return;
                                        }

                                        $set('id_daftar_url_serp', $extractedId);
                                    })
                                    ->columnSpan(1),
                                TextInput::make('visual_hasil_serp')
                                    ->label('Visual Hasil SERP')
                                    ->maxLength(255)
                                    ->live(onBlur: true)
                                    ->afterStateUpdated(function (Set $set, ?string $state) {
                                        $extractedId = self::extractGoogleDriveId($state);

                                        if ($extractedId === null) {
                                            return;
                                        }

                                        $set('id_visual_serp', $extractedId);
                                    })
                                    ->columnSpan(1),
                            ]),
                        Grid::make(2)
                            ->schema([
                                self::makeIdInput('id_visual_serp', 'ID Visual SERP')
                                    ->columnSpan(1),
                                self::makeIdInput('id_daftar_url_serp', 'ID Daftar URL SERP')
                                    ->columnSpan(1),
                            ]),
                        Textarea::make('daftar_5_referensi_url')
                            ->label('Daftar 5 Referensi URL')
                            ->rows(4)
                            ->autosize(),
                    ])
                    ->collapsible()
                    ->persistCollapsed()
                    ->id('serp-competitor'),

                Section::make('Ringkasan Profil')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                self::makeDriveAwareTextarea('ringkasan_profil_backlink', 'Ringkasan Profil Backlink', 'id_ringkasan_profil_backlink')
                                    ->columnSpan(2),
                                self::makeIdInput('id_ringkasan_profil_backlink', 'ID Ringkasan Profil Backlink')
                                    ->columnSpan(1),

                                self::makeDriveAwareTextarea('ringkasan_profil_internal_link', 'Ringkasan Profil Internal Link', 'id_ringkasan_profil_internal_link')
                                    ->columnSpan(2),
                                self::makeIdInput('id_ringkasan_profil_internal_link', 'ID Ringkasan Profil Internal Link')
                                    ->columnSpan(1),
                            ]),
                    ])
                    ->collapsible()
                    ->persistCollapsed()
                    ->id('ringkasan-profil'),

                Section::make('Analisa Kata Kunci')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                self::makeDriveAwareTextarea('ringkasan_analisa_kata_kunci', 'Ringkasan Analisa Kata Kunci', 'id_ringkasan_analisa_kata_kunci')
                                    ->columnSpan(2),
                                self::makeIdInput('id_ringkasan_analisa_kata_kunci', 'ID Ringkasan Analisa Kata Kunci')
                                    ->columnSpan(1),

                                self::makeDriveAwareTextarea('ringkasan_volume_kata_kunci', 'Ringkasan Volume Kata Kunci', 'id_ringkasan_volume_kata_kunci')
                                    ->columnSpan(2),
                                self::makeIdInput('id_ringkasan_volume_kata_kunci', 'ID Ringkasan Volume Kata Kunci')
                                    ->columnSpan(1),
                            ]),
                    ])
                    ->collapsible()
                    ->persistCollapsed()
                    ->id('analisa-kata-kunci'),
            ]);
    }
}
