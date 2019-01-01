<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "tag".
 *
 * @property integer $id
 * @property string $name
 *
 * @property PostHasTag[] $postHasTags
 * @property Post[] $posts
 */
class Tag extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tag';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'string', 'max' => 100],
            [['slug'],'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'شناسه',
            'name' => 'نام',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPostHasTags()
    {
        return $this->hasMany(PostHasTag::className(), ['tag_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPosts()
    {
        return $this->hasMany(Post::className(), ['id' => 'post_id'])->viaTable('post_has_tag', ['tag_id' => 'id']);
    }
    
    
    
    public static function getTagId($slug) {

        return Tag::find()->where('slug="' . $slug . '"')->One()->id;
    }

    public static function getSlug($title) {
        $title = str_replace('&#8204;', '*', $title);
        $title = str_replace('‌', '-', $title);
        $title = str_replace(' ً', '-', $title);
        $title = str_replace('ئٍ', '-', $title);
        $title = str_replace("ئ", "", $title);
        $title = str_replace('ُ', '', $title);
        $title = str_replace('ِ', '', $title);
        $title = str_replace('اً', '-', $title);
        $title = str_replace(' ', '-', $title);
        $title = str_replace('&zwnj;', '*', $title);
        $title = str_replace("\xE2\x80\x8B", "", $title);
        $title = str_replace(":", "", $title);
        $title = str_replace("»", "", $title);
        $title = str_replace('"', "", $title);
        $title = str_replace("«", "", $title);
        $title = str_replace(".", "", $title);
        $title = str_replace("!", "", $title);
        $title = str_replace("؟", "", $title);
        $title = str_replace("؟", "", $title);
        $title = str_replace("؟", "", $title);
        $title = str_replace("،", "", $title);
        $title = str_replace("?", "", $title);
        $title = str_replace("(", "-", $title);
        $title = str_replace(")", "-", $title);
        $title = str_replace(" ", "-", $title);
        $title = str_replace("/", "-", $title);
        $title = str_replace("+", "-", $title);
        $title = str_replace("--", "-", $title);
        $title = str_replace("---", "-", $title);

        return $post_id . $title;
    }
}
