<?php

namespace app\modules\v1\admin\category\controllers;

use Yii;
use app\helpers\ResponseBuilder;
use app\modules\v1\admin\category\models\Category;
use app\modules\v1\admin\category\models\form\CategoryForm;
use app\modules\v1\admin\category\models\search\CategorySearch;

class FormController extends Controller
{

    public function actionCreate()
    {
        $request = Yii::$app->request;
        if ($request->isPost) {
            $data = $request->post();
            if (!empty($data)) {
                $category = new CategoryForm();
                $category->load($data);
                if ($category->validate() && $category->save()) {
                    return ResponseBuilder::json(true, $category, "CREATE SUCCESS! ");
                }
                return ResponseBuilder::json(false, $category->getErrors(), "VALIDATE FAIL! ");
            }
            return ResponseBuilder::json(false, null, "MISING PARAMS! ");
        }
        return ResponseBuilder::json(false, null, "METHOD ALLOW POST! ");

    }

    public function actionUpdate()
    {
        $request = Yii::$app->request;
        if ($request->isPost) {
            $data = $request->post();
            $id = $request->post('id');
            if (!empty($id)) {
                $category = CategoryForm::find()->where(['id' => $id])->one();
                if (!empty($category)) {
                    $category->load($data);
                    if ($category->validate() && $category->save()) {
                        return ResponseBuilder::json(true, $category, "UPDATE SUCCESS! ");
                    }
                    return ResponseBuilder::json(false, $category->getErrors(), "VALIDATE FAIL! ");
                }
                return ResponseBuilder::json(false, $category->getErrors(), "DATA EMPTY! ");
            }
            return ResponseBuilder::json(false, null, "MISING PARAMS! ");
        }
        return ResponseBuilder::json(false, null, "METHOD ALLOW POST! ");
    }

    public function actionDelete()
    {
        $request = Yii::$app->request;
        if ($request->isPost) {
            $data = $request->post();
            $id = $data['id'];
            if (!empty($id)) {
                $category = Category::find()->where(['id' => $id])->one();
                if (!empty($category)) {
                    $category->status = Category::STATUS_DELETED;
                    $category->save(false);
                    return ResponseBuilder::json(true, $category, "UPDATE SUCCESS! ");
                }
                return ResponseBuilder::json(false, $category->getErrors(), "DATA EMPTY! ");
            }
            return ResponseBuilder::json(false, null, "MISING PARAMS! ");
        }
        return ResponseBuilder::json(false, null, "METHOD ALLOW POST! ");
    }

    public function actionView(int $id)
    {
        $request = Yii::$app->request;
        if ($request->isGet) {
            $id = $request->get('id');
            if (!empty($id)) {
                $category = Category::find()->where(['id' => $id])->one();
                if (!empty($category)) {
                    return ResponseBuilder::json(true, $category, "GET SUCCESS! ");
                }
                return ResponseBuilder::json(false, $category->getErrors(), "DATA EMPTY! ");
            }
            return ResponseBuilder::json(false, null, "MISING PARAMS! ");
        }
        return ResponseBuilder::json(false, null, "METHOD ALLOW GET! ");
    }

    public function actionIndex()
    {
        return ResponseBuilder::json(true, (new CategorySearch())->search(Yii::$app->request->queryParams));
    }
}
