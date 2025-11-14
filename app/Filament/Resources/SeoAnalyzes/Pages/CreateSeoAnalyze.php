<?php

namespace App\Filament\Resources\SeoAnalyzes\Pages;

use App\Filament\Resources\SeoAnalyzes\SeoAnalyzeResource;
use Filament\Resources\Pages\CreateRecord;

class CreateSeoAnalyze extends CreateRecord
{
    protected static string $resource = SeoAnalyzeResource::class;
    protected static ?string $title = 'Create SEO Analysis';
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getCreatedNotificationTitle(): ?string
    {
        return 'SEO Analysis created successfully';
    }
}
