<?php

namespace App\Filament\Resources\SeoAnalyzes\Pages;

use App\Filament\Resources\SeoAnalyzes\SeoAnalyzeResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSeoAnalyze extends EditRecord
{
    protected static string $resource = SeoAnalyzeResource::class;
    protected static ?string $title = 'Edit SEO Analysis';

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getSavedNotificationTitle(): ?string
    {
        return 'SEO Analysis updated successfully';
    }
}
