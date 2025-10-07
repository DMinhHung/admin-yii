<?php

namespace app\modules\v1\end_user\cart\controllers;

use app\modules\v1\end_user\cart\models\Cart;
use app\modules\v1\end_user\cart\models\CartItem;
use app\modules\v1\end_user\cart\models\form\CartForm;
use Yii;
use yii\web\HttpException;
use app\helpers\ResponseBuilder;
use app\modules\v1\end_user\cart\models\search\CartSearch;


class FormController extends Controller
{
    /**
     * @throws HttpException
     */
    public function actionIndex()
    {
        return ResponseBuilder::json(true, (new CartSearch())->search(Yii::$app->request->queryParams));
    }

    public function actionCreate()
    {
        $request = Yii::$app->request;
        if ($request->isPost) {
            $data = $request->post();
            if (!empty($data)) {
                $cart = new CartForm();
                $cart->load($data);
                if ($cart->validate() && $cart->save()) {
                    $cartItem = new CartItem();
                    $cartItem->cart_id = $cart->id;
                    $cartItem->item_id = $data['item_id'] ?? null;
                    $cartItem->quantity = $data['quantity'] ?? null;
                    $cartItem->price = $data['price'] ?? null;
                    $cartItem->save(false);
                    return ResponseBuilder::json(true, $cart, "CREATE SUCCESS! ");
                }
                return ResponseBuilder::json(true, $cart->getErrors(), "VALIDATE FAIL! ");
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
                $cart = CartForm::find()->where(['id' => $id])->one();
                if (!empty($cart)) {
                    $cart->load($data);
                    if ($cart->validate() && $cart->save()) {
                        return ResponseBuilder::json(true, $cart, "UPDATE SUCCESS! ");
                    }
                    return ResponseBuilder::json(true, $cart->getErrors(), "VALIDATE FAIL! ");
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
                $cart = Cart::find()->where(['id' => $id])->one();
                if (!empty($banner)) {
                    $cart->status = Cart::STATUS_DELETED;
                    $cart->save(false);
                    return ResponseBuilder::json(true, $cart, "UPDATE SUCCESS! ");
                }
                return ResponseBuilder::json(true, [], "DATA EMPTY! ");
            }
            return ResponseBuilder::json(false, null, "MISING PARAMS! ");
        }
        return ResponseBuilder::json(false, null, "METHOD ALLOW POST! ");
    }

}
