<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Spatie\Permission\Traits\HasRoles;
use App\Notifications\CustomVerifyEmail;


class User extends Authenticatable implements MustVerifyEmail
{
    use HasRoles;
    use HasFactory, Notifiable;
    protected $table = 'users';
    protected $keyType = 'string';
    public $incrementing = false;
    static public $estados = ["Activo","Inactivo","Bloqueado"];
    public $tipo = ["Desarrollador","Admin","Contabilidad","Atencion","Coordinacion","Maestro","Organizador"];


    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id',
        'name',
        'lastname',
        'avatar',
        'telephone',
        "user_type",
        'email',
        'estado',
        'codigo_maestro', // Para ser registrado como primer usuario "el creador del sistema"
        'password',
        'codigo_activacion', // asignado automaticamente por el sistema cuando admin crea un usuario
        'creado_por',
        'actualizado_por', 
        'ultimo_inicio',
        'fecha_activacion',
        'fecha_ultima_invite',
        'codigo_reset', 
        'envio_fecha_reset_codigo',
        'codigo_verificacion',
        'fecha_envio_verificacion',
        'avatar'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'codigo_primer_usuario',
        'password',
        'remember_token',
        'created_at',
        'updated_at',
    ];

   

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }


    static public function getUserByEmail($search){
        return User::select("*")
         ->where("email","like","%{$search}%");
    }

    public function sendEmailVerificationNotification()
    {
        $this->notify(new CustomVerifyEmail);
    }

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            if (empty($model->{$model->getKeyName()})) {
                $model->{$model->getKeyName()} = (string) Str::uuid();
            }
        });
    }

   
}
