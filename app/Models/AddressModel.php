<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AddressModel extends Model
{
    protected $table        = 'address';
    protected $primaryKey   = 'id';
    public $timestamps      = false;

    protected $fillable     = [
        'county', 'street_number', 'street_name', 'address_line2', 'address_line3', 'city', 'state', 'zip_code', 'square_footage', 'location', 'latitude', 'longitude', 'needs_recoding'
    ];
}
