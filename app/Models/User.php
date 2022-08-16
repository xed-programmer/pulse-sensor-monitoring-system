<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id',
        'email_sent'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function role()
    {
        return $this->hasOne(Role::class,'id', 'role_id');
    }

    public function hasRole($role)
    {
        $role = Role::where('name', $role)->first();        
        return $role->id == auth()->user()->role_id;
    }

    public function patients()
    {
        return $this->belongsToMany(Patient::class);
    }

    public function hasPatient(Patient $patient)
    {
        foreach($this->patients()->get() as $p){
            if($p->id == $patient->id){
                return true;
            }
        }
        return false;
    }
}
