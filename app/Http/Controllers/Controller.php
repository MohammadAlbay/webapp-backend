<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

abstract class Controller
{
    //


    public static function whichReturn(Request $request, $any, $json)
    {
        if ($request->isJson() || $request->wantsJson() || $request->ajax()) {
            return response()->json($json);
        } else {
            return $any;
        }
    }

    public static function jsonMessage($message, $state)
    {
        return ['Message' => $message, 'State' => $state];
    }


    public static function deleteFolder($dir)
    {
        if (!file_exists($dir)) {
            return false;
        }

        if (!is_dir($dir)) {
            return unlink($dir);
        }

        foreach (scandir($dir) as $item) {
            if ($item == '.' || $item == '..') {
                continue;
            }

            if (!Controller::deleteFolder($dir . DIRECTORY_SEPARATOR . $item)) {
                return false;
            }
        }

        return rmdir($dir);
    }
}
