<?php

namespace App\Filament\Resources\SeoAnalyzes\Tables;

use App\Models\SeoAnalyze;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class SeoAnalyzesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('status')
                    ->badge(),
                TextColumn::make('target_url')
                    ->label('Target URL')
                    ->searchable(),
                TextColumn::make('url_analisa')
                    ->label('URL Analisa')
                    ->searchable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->label('Status')
                    ->options([
                        'mulai analisa' => 'Mulai Analisa',
                        'daftar kompetitor telah dibuat' => 'Daftar Kompetitor Telah Dibuat',
                        'mulai analisa ke 2' => 'Mulai Analisa Ke 2',
                        'generate to pdf' => 'Generate to PDF',
                        'pdf generated' => 'PDF Generated',
                    ]),
            ])
            ->searchable(['target_url', 'url_analisa'])
            ->searchPlaceholder('Cari berdasarkan Target URL atau URL Analisa')
            ->recordActions([
                Action::make('previewPdf')
                    ->label('Lihat PDF')
                    ->icon('heroicon-o-document-magnifying-glass')
                    ->visible(fn(SeoAnalyze $record): bool => filled($record->url_analisa))
                    ->modalWidth('full')
                    ->modalHeading('Pratinjau URL Analisa')
                    ->modalSubmitActionLabel('Simpan Komentar')
                    ->modalContent(fn(SeoAnalyze $record) => view('filament.seo-analyzes.pdf-preview', [
                        'pdfPreviewUrl' => self::getPdfPreviewUrl($record->url_analisa),
                        'record' => $record,
                    ]))
                    ->form([
                        Textarea::make('komentar_url_analisa')
                            ->label('Komentar')
                            ->rows(4)
                            ->helperText('Tambahkan catatan untuk file PDF ini.')
                            ->columnSpanFull(),
                    ])
                    ->fillForm(fn(SeoAnalyze $record): array => [
                        'komentar_url_analisa' => $record->komentar_url_analisa,
                    ])
                    ->action(function (SeoAnalyze $record, array $data): void {
                        $record->update([
                            'komentar_url_analisa' => $data['komentar_url_analisa'] ?? null,
                        ]);
                    }),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    private static function getPdfPreviewUrl(?string $url): ?string
    {
        if (empty($url)) {
            return null;
        }

        if (str_contains($url, 'drive.google.com')) {
            if (preg_match('/\/d\/([a-zA-Z0-9_-]+)/', $url, $matches)) {
                return sprintf('https://drive.google.com/file/d/%s/preview#zoom=150', $matches[1]);
            }

            if (preg_match('/id=([a-zA-Z0-9_-]+)/', $url, $matches)) {
                return sprintf('https://drive.google.com/file/d/%s/preview#zoom=150', $matches[1]);
            }
        }

        return $url;
    }
}
