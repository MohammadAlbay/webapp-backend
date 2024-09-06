<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RolePermissions extends Model
{
    use HasFactory;
    protected $guarded = [];


    public function getRoleName() : string {
        return Role::find($this->role_id)->name;
    }
    public function getPermissionName() : string {
        return Permission::find($this->permission_id)->name;
    }
}
