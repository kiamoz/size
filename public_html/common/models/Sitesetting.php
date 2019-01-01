<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "sitesetting".
 *
 * @property string $fav
 * @property string $logo
 * @property string $title
 * @property string $description
 */
class Sitesetting extends \yii\db\ActiveRecord
{
    public $logoo, $favv;
    public static function tableName()
    {
        return 'sitesetting';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['fav', 'logo'], 'string', 'max' => 200],
            [['title'], 'string', 'max' => 100],
            [['description'], 'string', 'max' => 100],
            [['is_load_all_categories','pagination','hover_color','font_color','title_color','font_body_color','leftbox_color','header_color','latitude','longitude','keywords','facebook','googleplus','twitter','instagram','aparat','telegram','whatsapp','option_value',
                'tell','mobile','address','email','web','saat_kar','ads_banner_setting','main_color','internal_header_color','footer','credit_recommender','credit_recommended'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'fav' => 'فاو آیکون',
            'logo' => 'تصویر لوگو',
            'title' => 'عنوان',
            'description' => 'توضیحات',
            'keywords'=>'کلمات کلیدی',
            'tell' => 'شماره ثابت',
            'mobile' => 'شماره همراه',
            'address' => 'آدرس',
            'email' => 'آدرس ایمیل',
            'web' => 'وب',
            'saat_kar' => 'ساعت کار',
            'longitude'=>'طول جغرافیایی',
            'latitude'=>'عرض جغرافیایی',
            'header_color'=>'رنگ هدر',
            'credit_recommended'=>'اعتبار به کسی که معرفی شده است(ریال)',
            'credit_recommender'=>'اعتبار به کسی که معرفی میکند (ریال)'
        ];
    }
}
