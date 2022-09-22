<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\commands;

use app\models\Category;
use moonland\phpexcel\Excel;
use Yii;
use yii\console\Controller;
use yii\console\ExitCode;
use yii\grid\Column;

/**
 * This command echoes the first argument that you have entered.
 *
 * This command is provided as an example for you to learn how to create console commands.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class HelloController extends Controller
{
    /**
     * This command echoes what you have entered as the message.
     * @param string $message the message to be echoed.
     * @return int Exit code
     */
    public function actionIndex($message = 'hello world')
    {
        echo $message . "\n";

        return ExitCode::OK;
    }

    public function actionImportExcel()
    {
        $fileName = 'web/uploads/OpenSooqData.xlsx';

        $data = Excel::import($fileName, ['setFirstRecordAsKeys' => true, 'setIndexSheetByName' => true, 'getOnlySheet' => 'sheet1']);
        foreach ($data as $item) {
            //No need to use this it should be a model so that it gave the ID of the record
            $category = new Category();
            $category->name_ar = $item['name_ar'];
            $category->name_en = $item['name_en'];
            if ($category->save()) {
                $sub_categories = explode(',', $item['sub_categories']);
                foreach ($sub_categories as $category_name) {
                    $category_name = trim($category_name);
                    $sub_category = new Category();
                    $sub_category->name_ar = $category_name;
                    $sub_category->name_en = $category_name;
                    $sub_category->parent_id = $category->id;
                    $sub_category->save();
                }
            }
        }
    }
}
