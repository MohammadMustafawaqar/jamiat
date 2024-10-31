<?php

namespace App\Global;

use App\Helpers\HijriDate;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

class Settings
{
    public static function trans($en, $pa, $da, $ar = null)
    {

        switch (app()->getLocale()) {
            case 'en':
                return $en;
            case 'ps':
                return $pa;
            case 'dr':
                return $da;
            case 'ar':
                return $ar;
            default:
                return $ar;
        }
    }



    public static function change_from_hijri($date)
    {
        if ($date != null && $date != '') {
            $convertToHijri = new HijriDate();
            $gregorian = $convertToHijri->jalali_to_gregorian(explode('-', $date)[0], explode('-', $date)[1], explode('-', $date)[2]);

            return $gregorian[0] . '-' . $gregorian[1] . '-' . $gregorian[2];
        }
    }

    public static function change_to_hijri($date)
    {
        if ($date != null && $date != '') {
            $convertToHijri = new HijriDate();
            $hijri = $convertToHijri->gregorian_to_jalali(date('Y', strtotime($date)), date('m', strtotime($date)), date('d', strtotime($date)));

            return $hijri[0] . '-' . $hijri[1] . '-' . $hijri[2];
        }
    }

    public static function current_route($route_name)
    {
        if (Str::startsWith(Route::currentRouteName(), $route_name)) {
            return 'active';
        }

        return null;
    }


    public static function check_parent_route($routes)
    {

        for ($i = 0; $i < count($routes); $i++) {
            if (Str::startsWith(Route::currentRouteName(), $routes[$i])) {
                return 'is-expanded';
            }
        }

        return '';
    }
}
