<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    use HasFactory;
    
    protected $fillable = ['blog_title', 'blog_text', 'external_source', 'external_id', 'publication_datetime', 'user_id'];
}
