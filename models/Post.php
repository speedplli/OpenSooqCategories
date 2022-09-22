<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "post".
 *
 * @property int         $id
 * @property int|null    $category_id
 * @property int|null    $sub_category_id
 * @property int|null    $price
 * @property string|null $mobile
 *
 * @property Category    $category
 * @property Category    $subCategory
 */
class Post extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'post';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['category_id', 'sub_category_id', 'price'], 'integer'],
            [['mobile'], 'string'],
            ['mobile', 'match', 'pattern' => '/^07[789]\d{7}$/'],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Category::class, 'targetAttribute' => ['category_id' => 'id']],
            [['sub_category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Category::class, 'targetAttribute' => ['sub_category_id' => 'id']],
            ['sub_category_id', function ($attribute) {
                if (!$this->getSubCategory()->where(['id' => $this->category_id])->exist()) {
                    $this->addError($attribute, 'This sub category dos\'t exists or not child of the parent category');
                }
            }]
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'category_id' => 'Category ID',
            'sub_category_id' => 'Sub Category ID',
            'price' => 'Price',
            'mobile' => 'Mobile',
        ];
    }


    /**
     * Gets query for [[Category]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Category::class, ['id' => 'category_id']);
    }

    /**
     * Gets query for [[SubCategory]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSubCategory()
    {
        return $this->hasOne(Category::class, ['id' => 'sub_category_id']);
    }
}
