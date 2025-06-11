<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class PromocionAplicada extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'promociones_aplicadas';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'uuid';

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    /**
     * The data type of the primary key.
     *
     * @var string
     */
    protected $keyType = 'uuid';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'uuid',
        'id_promocion',
        'id_cuenta',
        'activo',
        'aplicado_por',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'uuid' => 'string',
        'activo' => 'boolean',
    ];

    /**
     * Get the promocion that was applied.
     */
    public function promocion(): BelongsTo
    {
        return $this->belongsTo(Promocion::class, 'id_promocion');
    }

    /**
     * Get the cuenta associated with the applied promocion.
     */
    public function cuenta(): BelongsTo
    {
        return $this->belongsTo(Cuenta::class, 'id_cuenta');
    }

    /**
     * Get the user who applied the promocion.
     */
    public function aplicadoPor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'aplicado_por');
    }
}
