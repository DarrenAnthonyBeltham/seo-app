<?php

namespace App\Filament\Resources\SeoAnalyzes;

use App\Filament\Resources\SeoAnalyzes\Pages\CreateSeoAnalyze;
use App\Filament\Resources\SeoAnalyzes\Pages\EditSeoAnalyze;
use App\Filament\Resources\SeoAnalyzes\Pages\ListSeoAnalyzes;
use App\Filament\Resources\SeoAnalyzes\Schemas\SeoAnalyzeForm;
use App\Filament\Resources\SeoAnalyzes\Tables\SeoAnalyzesTable;
use App\Models\SeoAnalyze;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Filament\Schemas\Schema;

class SeoAnalyzeResource extends Resource
{
    protected static ?string $model = SeoAnalyze::class;
    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-chart-bar';

    protected static ?string $navigationLabel = 'SEO Analysis';

    protected static ?string $modelLabel = 'SEO Analysis';

    protected static ?string $pluralModelLabel = 'SEO Analyses';

    protected static ?string $slug = 'seo-analysis';

    protected static ?int $navigationSort = 1;

    protected static ?string $recordTitleAttribute = 'kata_ kunci_utama';
    public static function form(Schema $schema): Schema {
        return SeoAnalyzeForm::configure($schema);
    }
    public static function table(Table $table): Table
    {
        return SeoAnalyzesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListSeoAnalyzes::route('/'),
            'create' => CreateSeoAnalyze::route('/create'),
            'edit' => EditSeoAnalyze::route('/{record}/edit'),
        ];
    }
}
