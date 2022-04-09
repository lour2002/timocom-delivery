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

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'company_settings';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'timocom_id',
        'name',
        'contact_person',
        'phone',
        'email'
    ];
}
