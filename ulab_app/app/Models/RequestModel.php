<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RequestModel extends Model
{
    protected $table = 'requests';

    protected $fillable = [
        'id_material',
        'id_status',
        'email',
        'phone',
        'contact_person',
        'test_basis',
        'batch_number',
        'sample_quantity',
    ];
}
