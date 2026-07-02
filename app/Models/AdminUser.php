<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

class AdminUser extends Model
{
    use HasFactory;

    protected $fillable = ['username', 'password', 'real_name', 'role_id', 'email', 'avatar', 'status'];

    public function role()
    {
        return $this->belongsTo(AdminRole::class);
    }

    public function hasPermission($permission)
    {
        // 直接从数据库查询角色信息，避免Session反序列化后关系丢失
        $role = AdminRole::find($this->role_id);

        if (!$role) {
            return false;
        }

        // Super admin has all permissions (只有super_admin)
        if ($role->role_name === 'super_admin') {
            return true;
        }

        // Check wildcard
        $permissions = $role->permissions ?? [];
        if (in_array('*', $permissions)) {
            return true;
        }

        // Check specific permission
        return in_array($permission, $permissions);
    }

    public function hasAnyPermission($permissions)
    {
        foreach ($permissions as $permission) {
            if ($this->hasPermission($permission)) {
                return true;
            }
        }
        return false;
    }

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = Hash::make($value);
    }
}
