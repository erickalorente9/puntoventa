<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    protected $fillable = [
        'provider_id',
        'user_id',
        'purchase_date',
        'tax',
        'total',
        'status',
    ];

    // Definir los campos de fecha que Laravel debe convertir a Carbon
    protected $dates = [
        'purchase_date',
        'created_at',
        'updated_at'
    ];

    // También puedes agregar un mutador para asegurar que la fecha se guarde correctamente
    protected function setPurchaseDateAttribute($value)
    {
        $this->attributes['purchase_date'] = \Carbon\Carbon::parse($value);
    }

    // Relaciones
    public function user() {
        return $this->belongsTo(User::class);
    }
    
    public function provider() {
        return $this->belongsTo(Provider::class);
    }
    
    public function purchaseDetails() {
        return $this->hasMany(PurchaseDetails::class);
    }

    // Opcional: Agregar un scope para obtener compras por estado
    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }
}