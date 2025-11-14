<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SeoAnalyze extends Model
{
    use HasFactory;

    protected $table = 'seo_analyze';

    protected $guarded = [];

    public $timestamps = false;
}