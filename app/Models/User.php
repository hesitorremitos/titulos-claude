<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Support\Arr;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, HasRoles, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'ci',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
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

    public function getAuthIdentifierName()
    {
        // Use the model primary key name (default is 'id').
        // Returning the primary key name ensures Laravel uses the numeric id
        // as the authenticated identifier while still allowing login via CI
        // in methods like findForPassport.
        return $this->getKeyName();
    }

    public function findForPassport($username)
    {
        return $this->where('ci', $username)->first();
    }

    public function activeRole(): ?string
    {
        $current = session('active_role');

        if ($current && $this->getRoleNames()->contains($current)) {
            return $current;
        }

        $fallback = $this->getRoleNames()->first();

        if ($fallback) {
            session(['active_role' => $fallback]);
        }

        return $fallback;
    }

    public function setActiveRole(string $role): void
    {
        if (! $this->getRoleNames()->contains($role)) {
            abort(403, 'No tienes asignado el rol solicitado.');
        }

        session(['active_role' => $role]);
    }

    public function activeRoleIs(string $role): bool
    {
        return $this->activeRole() === $role;
    }

    public function activeRoleIn(iterable $roles): bool
    {
        $rolesArray = Arr::wrap($roles);

        return in_array($this->activeRole(), $rolesArray, true);
    }
}
