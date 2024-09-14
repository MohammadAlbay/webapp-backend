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

    public  const PERMISSION_DELETE_EMPLOYEE_ID = 3,
                  PERMISSION_DELETE_EMPLOYEE_NAME = "Delete Employee";

    public  const PERMISSION_VIEW_EMPLOYEE_ID = 4,
                  PERMISSION_VIEW_EMPLOYEE_NAME = "View Employee";
     
                  
    public  const PERMISSION_ALLOW_LOGIN_ID = 5,
                  PERMISSION_ALLOW_LOGIN_NAME = "Allow Login";
    
    
    public  const PERMISSION_GENERATE_PREPAIDCARDS_ID = 6,
                  PERMISSION_GENERATE_PREPAIDCARDS_NAME = "Generate Prepaidcards";



    public  const PERMISSION_PRINT_PREPAIDCARDS_ID = 7,
                  PERMISSION_PRINT_PREPAIDCARDS_NAME = "Print Prepaidcards";


    public  const PERMISSION_VIEW_PREPAIDCARDS_ID = 8,
                  PERMISSION_VIEW_PREPAIDCARDS_NAME = "View Prepaidcards";


    public  const PERMISSION_MODIFY_PREPAIDCARDS_ID = 9,
                  PERMISSION_MODIFY_PREPAIDCARDS_NAME = "Modify Prepaidcards";

    public  const PERMISSION_EDIT_CUSTOMER_ID = 10,
                  PERMISSION_EDIT_CUSTOMER_NAME = "Edit Customer";


    public  const PERMISSION_VIEW_CUSTOMER_ID = 11,
                  PERMISSION_VIEW_CUSTOMER_NAME = "View Customer";


    public  const PERMISSION_BLOCK_CUSTOMER_ID = 12,
                  PERMISSION_BLOCK_CUSTOMER_NAME = "Block Customer";


    public  const PERMISSION_CUSTOMER_REPORTS_ID = 13,
                  PERMISSION_CUSTOMER_REPORTS_NAME = "Customer Reports";



    public  const PERMISSION_TECHNICAIN_EDIT_ID = 14,
                  PERMISSION_TECHNICAIN_EDIT_NAME = "Technicain Edit";
                  
    public  const PERMISSION_TECHNICAIN_VIEW_ID = 15,
                  PERMISSION_TECHNICAIN_VIEW_NAME = "Technicain View";
                  
    public  const PERMISSION_TECHNICAIN_BLOCK_ID = 16,
                  PERMISSION_TECHNICAIN_BLOCK_NAME = "Technicain Block";


    public  const PERMISSION_TECHNICAIN_REPORTS_ID = 17,
                  PERMISSION_TECHNICAIN_REPORTS_NAME = "Technicain Reports";


    public  const PERMISSION_PREPAIDCARDS_HISTORY_ID = 18,
                  PERMISSION_PREPAIDCARDS_HISTORY_NAME = "Prepaidcards History";
    
    public  const PERMISSION_VIEW_TRANSACTIONS_ID = 19,
                  PERMISSION_VIEW_TRANSACTIONS_NAME = "View Transactions";

    public  const PERMISSION_VIEW_ROLE_ID = 20,
                  PERMISSION_VIEW_ROLE_NAME = "View Role";


    public  const PERMISSION_ADD_ROLE_ID = 21,
                  PERMISSION_ADD_ROLE_NAME = "Add Role";


    public  const PERMISSION_EDIT_ROLE_ID = 22,
                  PERMISSION_EDIT_ROLE_NAME = "Edit Role";
    
    public  const PERMISSION_VIEW_PERMISSION_ID = 23,
                  PERMISSION_VIEW_PERMISSION_NAME = "View Permission";
    
    public  const PERMISSION_EDIT_PERMISSION_ID = 24,
                  PERMISSION_EDIT_PERMISSION_NAME = "Edit Permission";

    public  const PERMISSION_MANAGE_WALLETS_ID = 25,
                  PERMISSION_MANAGE_WALLETS_NAME = "Manage Wallets";
}
