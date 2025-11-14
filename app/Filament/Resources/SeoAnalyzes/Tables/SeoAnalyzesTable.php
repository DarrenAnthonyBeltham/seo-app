<?php

namespace App\Filament\Resources\SeoAnalyzes\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class SeoAnalyzesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('status')
                    ->badge(),
                TextColumn::make('kata_kunci_utama')
                    ->searchable(),
                TextColumn::make('target_url')
                    ->searchable(),
                TextColumn::make('konteks_lokal_negara')
                    ->searchable(),
                TextColumn::make('kata_kunci_serp_kompetitor')
                    ->searchable(),
                TextColumn::make('visual_hasil_serp')
                    ->searchable(),
                TextColumn::make('id_visual_serp')
                    ->searchable(),
                TextColumn::make('id_ringkasan_profil_backlink')
                    ->searchable(),
                TextColumn::make('id_ringkasan_profil_internal_link')
                    ->searchable(),
                TextColumn::make('id_ringkasan_analisa_kata_kunci')
                    ->searchable(),
                TextColumn::make('id_ringkasan_volume_kata_kunci')
                    ->searchable(),
                TextColumn::make('resiko_ymyl')
                    ->searchable(),
                TextColumn::make('url_analisa')
                    ->searchable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
