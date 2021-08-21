<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

/**
 * Class User
 * @package App\Models
 * @property int $id
 * @property string $email
 * @property string $password
 * @property int $role
 * @property string $phone
 * @property string $created_at
 */
class User extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens;

    /**
     * @var array
     */
    public const ROLES = [
        1   => 'Пользователь',
        2   => 'Модератор',
        3   => 'Администратор'
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role', // 1- user, 2- moderator, 3- admin
        'phone'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * @return string
     */
    public function getRole(): string
    {
        return self::ROLES[$this->role];
    }

    /**
     * @return bool
     */
    public function isUser(): bool
    {
        return $this->role == 1;
    }

    /**
     * @return bool
     */
    public function isModerator(): bool
    {
        return $this->role == 2;
    }

    /**
     * @return bool
     */
    public function isAdmin(): bool
    {
        return $this->role == 3;
    }
}
