<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "income_outcome".
 *
 * @property integer $id
 * @property string $date
 * @property string $amount
 * @property string $desc
 * @property integer $type_id
 * @property integer $model
 */
class Persian {

    static function gregorian_to_jalali($gy, $gm, $gd, $mod = '') {
        $g_d_m = array(0, 31, 59, 90, 120, 151, 181, 212, 243, 273, 304, 334);
        $jy = ($gy <= 1600) ? 0 : 979;
        $gy -= ($gy <= 1600) ? 621 : 1600;
        $gy2 = ($gm > 2) ? ($gy + 1) : $gy;
        $days = (365 * $gy) + ((int) (($gy2 + 3) / 4)) - ((int) (($gy2 + 99) / 100)) + ((int) (($gy2 + 399) / 400)) - 80 + $gd + $g_d_m[$gm - 1];
        $jy += 33 * ((int) ($days / 12053));
        $days %= 12053;
        $jy += 4 * ((int) ($days / 1461));
        $days %= 1461;
        $jy += (int) (($days - 1) / 365);
        if ($days > 365)
            $days = ($days - 1) % 365;
        $jm = ($days < 186) ? 1 + (int) ($days / 31) : 7 + (int) (($days - 186) / 30);
        $jd = 1 + (($days < 186) ? ($days % 31) : (($days - 186) % 30));
        return($mod == '') ? array($jy, sprintf("%02d", $jm), sprintf("%02d", $jd)) : $jy . $mod . $jm . $mod . $jd;
    }

    static function jalali_to_gregorian($jy, $jm, $jd, $mod = '') {
        $gy = ($jy <= 979) ? 621 : 1600;
        $jy -= ($jy <= 979) ? 0 : 979;
        $days = (365 * $jy) + (((int) ($jy / 33)) * 8) + ((int) ((($jy % 33) + 3) / 4)) + 78 + $jd + (($jm < 7) ? ($jm - 1) * 31 : (($jm - 7) * 30) + 186);
        $gy += 400 * ((int) ($days / 146097));
        $days %= 146097;
        if ($days > 36524) {
            $gy += 100 * ((int) ( --$days / 36524));
            $days %= 36524;
            if ($days >= 365)
                $days++;
        }
        $gy += 4 * ((int) (($days) / 1461));
        $days %= 1461;
        $gy += (int) (($days - 1) / 365);
        if ($days > 365)
            $days = ($days - 1) % 365;
        $gd = $days + 1;
        foreach (array(0, 31, (($gy % 4 == 0 and $gy % 100 != 0) or ( $gy % 400 == 0)) ? 29 : 28
    , 31, 30, 31, 30, 31, 31, 30, 31, 30, 31) as $gm => $v) {
            if ($gd <= $v)
                break;
            $gd -= $v;
        }
        return($mod == '') ? array($gy, $gm, $gd) : $gy . $mod . $gm . $mod . $gd;
    }

    public static function convert_date_to_en($date) {

        $o_dat_array = explode("/", $date);

        $en_date_array = Persian::jalali_to_gregorian($o_dat_array[0], $o_dat_array[1], $o_dat_array[2]);


        return $en_date_array[0] . "-" . $en_date_array[1] . "-" . $en_date_array[2];
    }

    public static function convert_date_to_fa($date,$show_time=false) {

        $o_dat_array = explode("-", $date);
        

        $en_date_array = Persian::gregorian_to_jalali($o_dat_array[0], $o_dat_array[1], $o_dat_array[2]);

        if($show_time){
            $o_dat_array_time = explode(" ", $date);
            $time = $o_dat_array_time[1];
        }
        return $en_date_array[0] . "/" . $en_date_array[1] . "/" . $en_date_array[2]." ".$time;
    }

    public static function get_last_day_of_month($month) {

        if ($month <= 6) {
            return 31;
        } else {
            return 30;
        }
    }

    public static function get_current_date() {
        return gregorian_to_jalali(date('Y'), date('m'), date('d'));
    }

}
