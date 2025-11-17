# SEO Analyze - Laravel Filament v4

A comprehensive SEO analysis management system built with Laravel and Filament v4. This application helps you track and manage SEO analysis workflows, competitor research, keyword analysis, and content optimization strategies.

## Features

- 📊 **Complete SEO Analysis Tracking** - Monitor SEO analysis from start to PDF generation
- 🔍 **SERP & Competitor Analysis** - Track competitor keywords and SERP results
- 📈 **Keyword Research** - Analyze keyword volume, expansion opportunities, and YMYL risks
- 🔗 **Backlink & Internal Link Profiling** - Monitor link building strategies
- 📝 **Content Structure Analysis** - Evaluate content patterns, outlines, and formats
- 🎯 **Audience & Intent Analysis** - Understand target demographics and user intent
- 🤖 **AI Optimization** - Track generative AI optimization strategies
- ✅ **Quality Testing** - Monitor content quality, rankings, and spam policy compliance
- 📄 **Optimization Reports** - Generate comprehensive optimization plans

## Requirements

- PHP 8.2 or higher
- Composer
- MySQL/MariaDB
- Node.js & NPM
- Laravel 11.x
- Filament 4.x

## Installation

### 1. Clone the Repository

```bash
git clone <your-repository-url>
cd seo-app
```

### 2. Install Dependencies

```bash
composer install
npm install
```

### 3. Environment Setup

```bash
cp .env.example .env
php artisan key:generate
```

Configure your database in `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=seo_analyze
DB_USERNAME=root
DB_PASSWORD=
```

### 4. Database Setup

Import the SQL file or run migrations:

```bash
mysql -u root -p seo_analyze < seo_analyze.sql
```

Or create migration manually:

```bash
php artisan make:migration create_seo_analyze_table
```

### 5. Install Filament

```bash
composer require filament/filament:"^4.0"
php artisan filament:install --panels
```

### 6. Create Filament User

```bash
php artisan make:filament-user
```

### 7. Generate Resource

```bash
php artisan make:filament-resource SeoAnalyze --generate
```

When prompted for title attribute, enter: `kata_kunci_utama`

### 8. File Structure

Place the following files in their respective directories:

```
app/
├── Models/
│   └── SeoAnalyze.php
└── Filament/
    └── Resources/
        ├── SeoAnalyzeResource.php
        └── SeoAnalyzes/
            ├── Pages/
            │   ├── ListSeoAnalyzes.php
            │   ├── CreateSeoAnalyze.php
            │   └── EditSeoAnalyze.php
            └── Schemas/
                └── SeoAnalyzeForm.php
```

### 9. Build Assets

```bash
npm run build
```

### 10. Serve Application

```bash
php artisan serve
```

Visit: `http://localhost:8000/admin`

## Database Schema

### Table: `seo_analyze`

| Column | Type | Description |
|--------|------|-------------|
| id | INT | Primary key |
| status | ENUM | Analysis status (mulai analisa, daftar kompetitor telah dibuat, mulai analisa ke 2, generate to pdf) |
| kata_kunci_utama | VARCHAR(255) | Main keyword |
| target_url | VARCHAR(255) | Target URL for analysis |
| konteks_lokal_negara | VARCHAR(255) | Local country context |
| kata_kunci_serp_kompetitor | VARCHAR(255) | Competitor SERP keywords |
| visual_hasil_serp | VARCHAR(255) | SERP visual results |
| id_visual_serp | VARCHAR(255) | SERP visual ID |
| daftar_5_referensi_url | TEXT | List of 5 reference URLs |
| ringkasan_profil_backlink | TEXT | Backlink profile summary |
| ringkasan_profil_internal_link | TEXT | Internal link profile summary |
| ringkasan_analisa_kata_kunci | TEXT | Keyword analysis summary |
| ringkasan_volume_kata_kunci | TEXT | Keyword volume summary |
| id_ringkasan_profil_backlink | VARCHAR(255) | Backlink profile summary ID |
| id_ringkasan_profil_internal_link | VARCHAR(255) | Internal link profile summary ID |
| id_ringkasan_analisa_kata_kunci | VARCHAR(255) | Keyword analysis summary ID |
| id_ringkasan_volume_kata_kunci | VARCHAR(255) | Keyword volume summary ID |
| url_analisa | VARCHAR(255) | Analysis URL |
| created_at | TIMESTAMP | Record creation timestamp |

## Usage

### Creating a New SEO Analysis

1. Navigate to **SEO Analyses** in the admin panel
2. Click **New Analysis**
3. Fill in the form sections:
   - **Basic Information**: Status, main keyword, target URL, country context
   - **SERP & Competitor Data**: Competitor keywords, SERP visuals, reference URLs
   - **Ringkasan Profil**: Backlink and internal link profiles
   - **Analisa Kata Kunci**: Keyword analysis, volume, YMYL risks
   - **Analisa Lanjutan**: Advanced content and audience analysis
   - **Pengujian & Hasil**: Quality testing and optimization results
4. Click **Create** to save

### Analysis Workflow Stages

1. **Mulai Analisa** - Initial analysis stage
2. **Daftar Kompetitor Telah Dibuat** - Competitor list created
3. **Mulai Analisa Ke 2** - Secondary analysis phase
4. **Generate to PDF** - Final report generation

### Filtering & Search

- Filter by status using the dropdown filter
- Search by keyword, target URL, or country
- Sort by any column in the table view

## Customization

### Custom Theme (Optional)

```bash
php artisan make:filament-theme
```

Add custom styles to `resources/css/filament/admin/theme.css`:

```css
.fi-section-content-ctn {
    @apply space-y-4;
}

.fi-fo-textarea textarea {
    min-height: 100px !important;
}
```

Build theme:

```bash
npm run build
```

### Modifying Form Layout

Edit `app/Filament/Resources/SeoAnalyzes/Schemas/SeoAnalyzeForm.php` to customize:
- Field types
- Validation rules
- Layout columns
- Section ordering

### Table Columns

Edit `SeoAnalyzeResource.php` `table()` method to customize:
- Visible columns
- Column formatting
- Sorting options
- Filters

## Troubleshooting

### "intl" module warning

If you see the warning about "intl" module, edit `php.ini`:
- Comment out duplicate `extension=intl` lines
- Keep only one instance

### Form fields not aligned

Run:
```bash
php artisan filament:cache-components
php artisan optimize:clear
```

### Permissions Issues

Ensure storage and bootstrap/cache directories are writable:
```bash
chmod -R 775 storage bootstrap/cache
```

## Security

- Always use `.env` for sensitive configuration
- Never commit `.env` file to version control
- Use strong passwords for admin users
- Keep Laravel and Filament updated
- Enable CSRF protection (enabled by default)

## Contributing

1. Fork the repository
2. Create a feature branch
3. Commit your changes
4. Push to the branch
5. Create a Pull Request

## License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

## Support

For issues and questions:
- Check the [Filament documentation](https://filamentphp.com/docs)
- Review [Laravel documentation](https://laravel.com/docs)
- Open an issue on GitHub

## Credits

- Built with [Laravel](https://laravel.com)
- Admin panel by [Filament](https://filamentphp.com)
- Database: MariaDB/MySQL

---

**Version:** 1.0.0  
**Last Updated:** November 14, 2025
