<?php

namespace App\Filament\Resources\SeoAnalyzes\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Schema;

class SeoAnalyzeForm
{
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
                                    ])
                                    ->default('mulai analisa')
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
                            ->maxLength(255),
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
                                    ->columnSpan(1),
                                TextInput::make('visual_hasil_serp')
                                    ->label('Visual Hasil SERP')
                                    ->maxLength(255)
                                    ->columnSpan(1),
                            ]),
                        TextInput::make('id_visual_serp')
                            ->label('ID Visual SERP')
                            ->maxLength(255),
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
                                Textarea::make('ringkasan_profil_backlink')
                                    ->label('Ringkasan Profil Backlink')
                                    ->rows(4)
                                    ->autosize()
                                    ->columnSpan(1),
                                TextInput::make('id_ringkasan_profil_backlink')
                                    ->label('ID Ringkasan Profil Backlink')
                                    ->maxLength(255)
                                    ->columnSpan(1),
                            ]),
                        Grid::make(2)
                            ->schema([
                                Textarea::make('ringkasan_profil_internal_link')
                                    ->label('Ringkasan Profil Internal Link')
                                    ->rows(4)
                                    ->autosize()
                                    ->columnSpan(1),
                                TextInput::make('id_ringkasan_profil_internal_link')
                                    ->label('ID Ringkasan Profil Internal Link')
                                    ->maxLength(255)
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
                                Textarea::make('ringkasan_analisa_kata_kunci')
                                    ->label('Ringkasan Analisa Kata Kunci')
                                    ->rows(4)
                                    ->autosize()
                                    ->columnSpan(1),
                                TextInput::make('id_ringkasan_analisa_kata_kunci')
                                    ->label('ID Ringkasan Analisa Kata Kunci')
                                    ->maxLength(255)
                                    ->columnSpan(1),
                            ]),
                        Grid::make(2)
                            ->schema([
                                Textarea::make('ringkasan_volume_kata_kunci')
                                    ->label('Ringkasan Volume Kata Kunci')
                                    ->rows(4)
                                    ->autosize()
                                    ->columnSpan(1),
                                TextInput::make('id_ringkasan_volume_kata_kunci')
                                    ->label('ID Ringkasan Volume Kata Kunci')
                                    ->maxLength(255)
                                    ->columnSpan(1),
                            ]),
                        TextArea::make('resiko_ymyl')
                            ->label('Resiko YMYL')
                            ->rows(3)
                            ->autosize(),
                    ])
                    ->collapsible()
                    ->persistCollapsed()
                    ->id('analisa-kata-kunci'),

                Section::make('Analisa Lanjutan')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                Textarea::make('analisa_perluasan_kata_kunci')
                                    ->label('Analisa Perluasan Kata Kunci')
                                    ->rows(4)
                                    ->autosize()
                                    ->columnSpan(1),
                                Textarea::make('analisa_pola_struktur_konten')
                                    ->label('Analisa Pola Struktur Konten')
                                    ->rows(4)
                                    ->autosize()
                                    ->columnSpan(1),
                            ]),
                        Grid::make(2)
                            ->schema([
                                Textarea::make('analisa_standar_outline')
                                    ->label('Analisa Standar Outline')
                                    ->rows(4)
                                    ->autosize()
                                    ->columnSpan(1),
                                Textarea::make('analisa_jenis_konten_pilihan')
                                    ->label('Analisa Jenis Konten Pilihan')
                                    ->rows(4)
                                    ->autosize()
                                    ->columnSpan(1),
                            ]),
                        Grid::make(2)
                            ->schema([
                                Textarea::make('analisa_audiens_intensi_demografi')
                                    ->label('Analisa Audiens Intensi Demografi')
                                    ->rows(4)
                                    ->autosize()
                                    ->columnSpan(1),
                                Textarea::make('analisa_generatif_ai_optimization')
                                    ->label('Analisa Generatif AI Optimization')
                                    ->rows(4)
                                    ->autosize()
                                    ->columnSpan(1),
                            ]),
                    ])
                    ->collapsible()
                    ->persistCollapsed()
                    ->id('analisa-lanjutan'),

                Section::make('Pengujian & Hasil')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                Textarea::make('analisa_pengujian_kualitas_konten')
                                    ->label('Analisa Pengujian Kualitas Konten')
                                    ->rows(4)
                                    ->autosize()
                                    ->columnSpan(1),
                                Textarea::make('analisa_pengujian_peringkat')
                                    ->label('Analisa Pengujian Peringkat')
                                    ->rows(4)
                                    ->autosize()
                                    ->columnSpan(1),
                            ]),
                        Grid::make(2)
                            ->schema([
                                Textarea::make('analisa_pengujian_kebijakan_spam')
                                    ->label('Analisa Pengujian Kebijakan Spam')
                                    ->rows(4)
                                    ->autosize()
                                    ->columnSpan(1),
                                Textarea::make('result_rencana_optimasi')
                                    ->label('Result Rencana Optimasi')
                                    ->rows(4)
                                    ->autosize()
                                    ->columnSpan(1),
                            ]),
                    ])
                    ->collapsible()
                    ->persistCollapsed()
                    ->id('pengujian-hasil'),
            ]);
    }
}