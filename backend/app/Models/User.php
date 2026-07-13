<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Role;
use App\Models\AuditLog;
use App\Models\Lead;
use App\Models\SalesTask;
use App\Models\RolePagePermission;
use App\Models\UserPagePermission;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    protected $fillable = [
        'role_id',
        'full_name',
        'email',
        'password',
        'archived_by',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];
    protected $casts = [
        'password' => 'hashed', // Laravel 10+ auto-hashes
    ];
    public function Role(){
        return $this->belongsTo(Role::class);
    }

    public function archivedBy()
    {
        return $this->belongsTo(User::class, 'archived_by');
    }

    public function audit_log(){

        return $this->hasMany(AuditLog::class);
    }

    public function Lead(){
        return $this->hasMany(Lead::class);
    }
    public function Sales_Task(){
        return $this->hasMany(SalesTask::class);
    }
    public function performance_plan(){
        return $this->hasMany(performancePlan::class);
    }

    /**
     * Relation: this user's individual permission overrides.
     */
    public function userPagePermissions()
    {
        return $this->hasMany(UserPagePermission::class, 'user_id');
    }

    /**
     * Get the effective permission for this user on a given page.
     * User-level override wins if it exists; otherwise falls back to the role's permission.
     *
     * @param int $pageId
     * @return array{can_view: bool, can_create: bool, can_edit: bool, can_archive: bool}
     */
    public function getEffectivePagePermission(int $pageId): array
    {
        $rolePermission = RolePagePermission::where('role_id', $this->role_id)
            ->where('page_id', $pageId)
            ->first();

        $userOverride = UserPagePermission::where('user_id', $this->id)
            ->where('page_id', $pageId)
            ->first();

        // Defaults if role has no permission row at all for this page
        $base = [
            'can_view'    => $rolePermission->can_view ?? false,
            'can_create'  => $rolePermission->can_create ?? false,
            'can_edit'    => $rolePermission->can_edit ?? false,
            'can_archive' => $rolePermission->can_archive ?? false,
        ];

        if (!$userOverride) {
            return $base;
        }

        // Only overwrite fields that are explicitly set (not null) on the user override
        foreach (['can_view', 'can_create', 'can_edit', 'can_archive'] as $field) {
            if (!is_null($userOverride->{$field})) {
                $base[$field] = $userOverride->{$field};
            }
        }

        return $base;
    }

    /**
     * Quick check helper, e.g. $user->hasPagePermission($pageId, 'can_edit')
     */
    public function hasPagePermission(int $pageId, string $permission): bool
    {
        $permissions = $this->getEffectivePagePermission($pageId);
        return $permissions[$permission] ?? false;
    }
}
