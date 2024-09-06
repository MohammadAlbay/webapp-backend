<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    use HasFactory;

    protected $guarded = [];
    
    public  const PERMISSION_ADD_EMPLOYEE_ID = 1,
                  PERMISSION_ADD_EMPLOYEE_NAME = "Add Employee";

    public  const PERMISSION_EDIT_EMPLOYEE_ID = 2,
                  PERMISSION_EDIT_EMPLOYEE_NAME = "Edit Employee";

    public  const PERMISSION_VIEW_REPORTS_ID = 3,
                  PERMISSION_VIEW_REPORTS_NAME = "View Reports";

                  
}
