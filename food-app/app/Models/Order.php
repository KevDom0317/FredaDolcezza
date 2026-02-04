<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_name',
        'customer_phone',
        'total',
        'status',
        'notes',
    ];

    protected $casts = [
        'total' => 'decimal:2',
    ];

    /**
     * Relación: Un pedido tiene muchos items
     */
    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * Scope para obtener pedidos por estado
     */
    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Scope para obtener pedidos pendientes
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pendiente');
    }

    /**
     * Scope para obtener pedidos en preparación
     */
    public function scopeInPreparation($query)
    {
        return $query->where('status', 'en_preparacion');
    }

    /**
     * Scope para obtener pedidos entregados
     */
    public function scopeDelivered($query)
    {
        return $query->where('status', 'entregado');
    }
}
