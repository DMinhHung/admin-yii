<?php


namespace app\modules\v1\admin\news\controllers;

use Yii;
use app\helpers\ResponseBuilder;
use app\modules\v1\admin\news\models\News;
use app\modules\v1\admin\news\models\form\NewsForm;
use app\modules\v1\admin\news\models\search\NewsSearch;

class FormController extends Controller
{

    public function actionCreate()
    {
        $request = Yii::$app->request;
        if ($request->isPost) {
            $data = $request->post();
            if (!empty($data)) {
                $banner = new NewsForm();
                $banner->load($data);
                if ($banner->validate() && $banner->save()) {
                    return ResponseBuilder::json(true, $banner, "CREATE SUCCESS! ");
                }
                return ResponseBuilder::json(true, $banner->getErrors(), "VALIDATE FAIL! ");
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
                $banner = NewsForm::find()->where(['id' => $id])->one();
                if (!empty($banner)) {
                    $banner->load($data);
                    if ($banner->validate() && $banner->save()) {
                        return ResponseBuilder::json(true, $banner, "UPDATE SUCCESS! ");
                    }
                    return ResponseBuilder::json(true, $banner->getErrors(), "VALIDATE FAIL! ");
                }
                return ResponseBuilder::json(true, [], "DATA EMPTY! ");
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
                $banner = News::find()->where(['id' => $id])->one();
                if (!empty($banner)) {
                    $banner->status = News::STATUS_DELETED;
                    $banner->save(false);
                    return ResponseBuilder::json(true, $banner, "UPDATE SUCCESS! ");
                }
                return ResponseBuilder::json(true, [], "DATA EMPTY! ");
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
                $banner = News::find()->where(['id' => $id])->one();
                if (!empty($banner)) {
                    return ResponseBuilder::json(true, $banner, "GET SUCCESS! ");
                }
                return ResponseBuilder::json(true, [], "DATA EMPTY! ");
            }
            return ResponseBuilder::json(false, null, "MISING PARAMS! ");
        }
        return ResponseBuilder::json(false, null, "METHOD ALLOW GET! ");
    }

    public function actionIndex()
    {
        return ResponseBuilder::json(true, (new NewsSearch())->search(Yii::$app->request->queryParams));
    }
}
