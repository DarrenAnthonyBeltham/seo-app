<?php

namespace App\Filament\Resources\SeoAnalyzes\Pages;

use App\Filament\Resources\SeoAnalyzes\SeoAnalyzeResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSeoAnalyzes extends ListRecords
{
    protected static string $resource = SeoAnalyzeResource::class;

    protected static ?string $title = 'SEO Analysis';

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('New Analysis'),
        ];
    }
}