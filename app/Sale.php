<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    protected $fillable = [
        'client_id',
        'user_id',
        'sale_date',
        'tax',
        'total',
        'status',
    ];

        // Definir los campos de fecha que Laravel debe convertir a Carbon
        protected $dates = [
            'sale_date',
            'created_at',
            'updated_at'
        ];
    
        // También puedes agregar un mutador para asegurar que la fecha se guarde correctamente
        protected function setSaleDateAttribute($value)
        {
            $this->attributes['sale_date'] = \Carbon\Carbon::parse($value);
        }
    

    public function user() {
        return $this->belongsTo(User::class);
    }
    
    public function client() {
        return $this->belongsTo(Client::class);
    }
    
    public function saleDetails() {
        return $this->hasMany(saleDetail::class);
    }
}