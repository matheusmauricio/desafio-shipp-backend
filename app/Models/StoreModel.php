<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StoreModel extends Model
{
    protected $table        = 'store';
    protected $primaryKey   = 'id';
    public $timestamps      = false;

    protected $fillable     = [
        'license_number', 'operation_type', 'establishment_type', 'entity_name', 'dba_name'
    ];
}
