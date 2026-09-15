<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Request extends Model
{
    protected $table = 'requests';

    protected $fillable = [
        'id_material',
        'id_status',
        'email',
        'phone',
        'customer',
        'basis_contest',
        'batch_number',
        'count_probes',
        'contact_person',
        'custom_fields',
    ];

    protected $casts = [
        'custom_fields' => 'array',
    ];
}
