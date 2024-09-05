<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class PrepaidCard extends Model
{
    use HasFactory;
    protected $guarded = [];


    public static function getGenerationsDetails()
    {
        return DB::select('SELECT concat("Gen ", Cast(ROW_NUMBER() OVER(PARTITION BY \'a\' ) As char)) AS row_num,'.
                            'DATE_FORMAT(created_at, "%Y-%m-%d %h:%i") As Date, count(*) AS \'Generated\', money As Category, '.
                            'money * count(*) As Total '.
                            ' FROM prepaid_cards '.
                            'GROUP BY DATE_FORMAT(created_at, "%i-%h-%d-%m-%y"), money '.
                            'ORDER BY DATE_FORMAT(created_at, "%i-%h-%d-%m-%y"), money DESC');
    }

    public static function getGenerationModelList($genDate, $money) {
        $results = DB::select('select * from prepaid_cards where DATE_FORMAT(created_at, "%Y-%m-%d %h:%i") like ? AND money = ?;', [$genDate, $money]);
        return PrepaidCard::hydrate($results);
    }
    
    
    
    
    
    
    
    
    
    
    
    
    // public static function getGenerationsDetailsDecorated()
    // {
    //     return DB::select("SELECT concat(\"Gen \", Cast(ROW_NUMBER() OVER(PARTITION BY 'some column' ) As char)) AS row_num, 
    //                         created_at, count(*) AS 'generated', concat(FORMAT(money,2,'en_US'), \"  LYD\") As Category, 
    //                         concat(FORMAT(money * count(money),2,'en_US'), \"  LYD\") As Total
    //                         FROM prepaid_cards 
    //                         GROUP BY DATE_FORMAT(created_at, \"%i-%h-%d-%m-%y\")
    //                         ORDER BY YEAR(created_at) DESC, MONTH(created_at) DESC)");
    // } 
}
