<?php

namespace App\Filament\Resources\SeoAnalyzes\Tables;

use App\Models\SeoAnalyze;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Textarea;
use Filament\Notifications\Notification;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Http;

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
                Action::make('triggerPdfWebhook')
                    ->label('Trigger Webhook')
                    ->icon('heroicon-o-share')
                    ->color('success')
                    ->requiresConfirmation()
                    ->visible(fn(SeoAnalyze $record): bool => $record->status === 'generate to pdf')
                    ->action(function (SeoAnalyze $record): void {
                        $url = config('services.make_webhook.url');
                        $apiKey = config('services.make_webhook.api_key');

                        if (empty($url) || empty($apiKey)) {
                            Notification::make()
                                ->title('Konfigurasi webhook belum lengkap.')
                                ->body('Pastikan MAKE_WEBHOOK_URL dan MAKE_WEBHOOK_API_KEY sudah diatur.')
                                ->danger()
                                ->send();

                            return;
                        }

                        $response = Http::withHeaders([
                            'x-make-apikey' => $apiKey,
                        ])->post($url, [
                            'seo_analyze_id' => $record->id,
                            'status' => $record->status,
                            'target_url' => $record->target_url,
                            'url_analisa' => $record->url_analisa,
                            'kata_kunci_utama' => $record->kata_kunci_utama,
                        ]);

                        if ($response->successful()) {
                            $record->update(['status' => 'pdf generated']);

                            Notification::make()
                                ->title('Webhook berhasil dikirim')
                                ->body('Status telah diperbarui menjadi PDF Generated.')
                                ->success()
                                ->send();
                        } else {
                            Notification::make()
                                ->title('Webhook gagal dikirim')
                                ->body($response->body() ?: 'Periksa log aplikasi untuk detailnya.')
                                ->danger()
                                ->send();
                        }
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
