<?php

namespace App\Models;

use App\Models\Role;
use App\Models\Instance;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Notifications\ResetPasswordNotification;
use App\Notifications\EmailVerificationNotification;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements MustVerifyEmail
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
        'username',
        'role_id',
        'instance_id',
        'hp',
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
        return $this->belongsTo(Role::class);
    }

    public function instance()
    {
        return $this->belongsTo(Instance::class);
    }

    public function sendPasswordResetNotification($token)
    {
        $url = 'http://mkwlapor.com/reset-password?token=' . $token;

        $this->notify(new ResetPasswordNotification($url));
    }

    public function sendEmailVerificationNotification()
    {
        // We override the default notification and will use our own
        $this->notify(new EmailVerificationNotification());
    }
}
