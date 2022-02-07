<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Attachment\Attachable;
use Orchid\Filters\Filterable;
use Orchid\Screen\AsSource;

class CompanySettings extends Model
{
    use AsSource, Filterable, Attachable;

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
