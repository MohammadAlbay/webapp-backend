<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use \Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Models\EmployeeRole;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Employee extends Authenticatable
{
    use HasFactory;
    protected $guarded = [];

    protected static function booted()
    {
        static::created(function ($employee) {
            if($employee->role_id->name == "System")
                $employee->wallet()->create();
        });
    }
    
    public function wallet()
    {
        return $this->morphOne(Wallet::class, 'owner');
    }
    
    public function transactions() {
        return $this->morphMany(PrepaidCardMovement::class, 'owner');
    }
    
    public function getPermissionList() : Collection {
        return $this->role()->permissions;
    }

    public function role() : Role {
        return Role::find($this->role_id);
    }

    public function hasPermissionId(int $permissionID) : bool {
        foreach($this->getPermissionList() as $p) {
            if($p->permission_id == $permissionID && $p->state == 'Active')
                return true;
        }
        return false;
    }
    public function hasPermission(string $permission) : bool {
        foreach($this->getPermissionList() as $p) {
            if($p->getPermissionName() == $permission && $p->state == 'Active')
                return true;
        }
        return false; 
    }


    public function haveUpperHandOver($admin_id) {
        return $this->id < $admin_id;
    }

    public static function getSystem() {
        return Employee::find(2);
    }
}
