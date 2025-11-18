<?php

namespace App\Filament\Resources\SeoAnalyzes\Pages;

use App\Filament\Resources\SeoAnalyzes\SeoAnalyzeResource;
use App\Models\SeoAnalyze;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Support\Facades\Http;

class ListSeoAnalyzes extends ListRecords
{
    protected static string $resource = SeoAnalyzeResource::class;

    protected static ?string $title = 'SEO Analysis';

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('New Analysis'),
            Actions\Action::make('triggerWebhookAll')
                ->label('Generate PDF')
                ->color('success')
                ->icon('heroicon-o-document-text')
                ->requiresConfirmation()
                ->action(function (): void {
                    $records = SeoAnalyze::query()
                        ->where('status', 'generate to pdf')
                        ->get();

                    if ($records->isEmpty()) {
                        Notification::make()
                            ->title('Tidak ada data dengan status Generate to PDF.')
                            ->warning()
                            ->send();

                        return;
                    }

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

                    $failed = [];

                    foreach ($records as $record) {
                        $response = Http::withHeaders([
                            'x-make-apikey' => $apiKey,
                        ])->post($url, [
                            'seo_analyze_id' => $record->id,
                            'status' => $record->status,
                            'target_url' => $record->target_url,
                            'url_analisa' => $record->url_analisa,
                            'kata_kunci_utama' => $record->kata_kunci_utama,
                        ]);

                        if (! $response->successful()) {
                            $failed[] = $record->id;
                        }
                    }

                    if (empty($failed)) {
                        Notification::make()
                            ->title('Webhook berhasil dikirim')
                            ->body('Semua data berhasil dikirim ke webhook.')
                            ->success()
                            ->send();
                    } else {
                        Notification::make()
                            ->title('Sebagian webhook gagal')
                            ->body('Gagal untuk ID: ' . implode(', ', $failed))
                            ->danger()
                            ->send();
                    }
                }),
            Actions\Action::make('triggerStartAnalysis')
                ->label('Mulai Analisa')
                ->color('warning')
                ->icon('heroicon-o-play')
                ->requiresConfirmation()
                ->action(function (): void {
                    $records = SeoAnalyze::query()
                        ->where('status', 'mulai analisa ke 2')
                        ->get();

                    if ($records->isEmpty()) {
                        Notification::make()
                            ->title('Tidak ada data dengan status Mulai Analisa Ke 2.')
                            ->warning()
                            ->send();

                        return;
                    }

                    $url = 'https://hook.eu2.make.com/nk7tij1mgu173mn94b6xsylp4uyymcby';
                    $apiKey = config('services.make_webhook.api_key');

                    if (empty($apiKey)) {
                        Notification::make()
                            ->title('Konfigurasi API key webhook belum lengkap.')
                            ->body('Pastikan MAKE_WEBHOOK_API_KEY sudah diatur.')
                            ->danger()
                            ->send();

                        return;
                    }

                    $failed = [];

                    foreach ($records as $record) {
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
                            $record->update(['status' => 'generate to pdf']);
                        } else {
                            $failed[] = $record->id;
                        }
                    }

                    if (empty($failed)) {
                        Notification::make()
                            ->title('Webhook Mulai Analisa berhasil dikirim')
                            ->body('Semua data status Mulai Analisa Ke 2 telah dikirim dan diperbarui ke Generate to PDF.')
                            ->success()
                            ->send();
                    } else {
                        Notification::make()
                            ->title('Sebagian webhook Mulai Analisa gagal')
                            ->body('Gagal untuk ID: ' . implode(', ', $failed))
                            ->danger()
                            ->send();
                    }
                }),
        ];
    }
}
