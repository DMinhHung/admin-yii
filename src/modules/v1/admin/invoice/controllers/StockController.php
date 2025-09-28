<?php

namespace app\modules\v1\admin\invoice\controllers;

use Yii;
use app\models\ItemVariant;
use app\helpers\ResponseBuilder;
use app\modules\v1\admin\product\models\Item;
use app\modules\v1\admin\invoice\models\StockInvoice;
use app\modules\v1\admin\invoice\models\StockInvoiceItem;
use app\modules\v1\admin\invoice\models\form\StockInvoiceForm;
use app\modules\v1\admin\invoice\models\search\StockInvoiceSearch;

class StockController extends Controller
{
    public function actionCreate()
    {
        $request = Yii::$app->request;
        if ($request->isPost) {
            $data = $request->post();
            if (!empty($data)) {
                $transaction = Yii::$app->db->beginTransaction();
                try {
                    $invoice = new StockInvoiceForm();
                    $invoice->load($data);

                    if ($invoice->validate() && $invoice->save()) {
                        $itemsData = $data['items'] ?? [];
                        if (!empty($itemsData)) {
                            foreach ($itemsData as $itemData) {
                                $invoiceItem = new StockInvoiceItem();
                                $invoiceItem->load($itemData);
                                $invoiceItem->invoice_id = $invoice->id;
                                $invoiceItem->save(false);
                                $item = ItemVariant::find()->where(['id' => $invoiceItem->product_variant_id])->one();
                                if (!empty($item)) {
                                    $invoiceItem->old_quantity = $item->stock;
                                    $invoiceItem->save(false);
                                    if ($invoice->type == StockInvoice::TYPE_IN) {
                                        $item->stock += $invoiceItem->quantity;
                                    } elseif ($invoice->type == StockInvoice::TYPE_OUT || $invoice->type == StockInvoice::TYPE_DESTROY) {
                                        $item->stock -= $invoiceItem->quantity;
                                    }
                                    $item->save(false);
                                }
                            }
                        }
                        $transaction->commit();
                        return ResponseBuilder::json(true, $invoice, "CREATE SUCCESS!");
                    }
                    $transaction->rollBack();
                    return ResponseBuilder::json(true, $invoice->getErrors(), "VALIDATE FAIL!");
                } catch (\Throwable $e) {
                    $transaction->rollBack();
                    return ResponseBuilder::json(false, null, $e->getMessage());
                }
            }
            return ResponseBuilder::json(false, null, "MISSING PARAMS!");
        }
        return ResponseBuilder::json(false, null, "METHOD ALLOW POST!");
    }

    public function actionUpdate()
    {
        $request = Yii::$app->request;
        if ($request->isPost) {
            $data = $request->post();
            $id = $request->post('id');
            if (!empty($id)) {
                $invoice = StockInvoice::find()->where(['id' => $id])->one();
                if (!empty($invoice)) {
                    $transaction = Yii::$app->db->beginTransaction();
                    try {
                        $invoice->load($data);
                        if ($invoice->validate() && $invoice->save()) {
                            $invoiceItems = StockInvoiceItem::find()->where(['invoice_id' => $invoice->id])->all();
                            foreach ($invoiceItems as $iv) {
                                $item = ItemVariant::find()->where(['id' => $iv->product_variant_id, 'status' => ItemVariant::STATUS_ACTIVE])->one();
                                $item->stock = $iv->old_quantity;
                                $item->save(false);
                            }
                            $itemsData = $data['items'] ?? [];
                            if (!empty($itemsData)) {
                                foreach ($itemsData as $itemData) {
                                    $invoiceItem = StockInvoiceItem::find()->where(['invoice_id' => $invoice->id, 'product_variant_id' => $itemData['product_variant_id']])->one();
                                    if (!empty($invoiceItem)) {
                                        $invoiceItem->quantity = $itemData['quantity'];
                                        $invoiceItem->price = $itemData['price'];
                                        $invoiceItem->total = $itemData['total'];
                                    } else {
                                        $invoiceItem = new StockInvoiceItem();
                                        $invoiceItem->load($itemData);
                                        $invoiceItem->invoice_id = $invoice->id;
                                    }
                                    $invoiceItem->save(false);
                                    $item = ItemVariant::find()->where(['id' => $invoiceItem->product_variant_id])->one();
                                    if (!empty($item)) {
                                        if ($invoice->type == StockInvoice::TYPE_IN) {
                                            $item->stock += $invoiceItem->quantity;
                                        } elseif ($invoice->type == StockInvoice::TYPE_OUT || $invoice->type == StockInvoice::TYPE_DESTROY) {
                                            $item->stock -= $invoiceItem->quantity;
                                        }
                                        $item->save(false);
                                    }
                                }
                            }
                            $transaction->commit();
                            return ResponseBuilder::json(true, $invoice, "UPDATE SUCCESS!");
                        }
                        $transaction->rollBack();
                        return ResponseBuilder::json(true, $invoice->getErrors(), "VALIDATE FAIL!");
                    } catch (\Throwable $e) {
                        $transaction->rollBack();
                        return ResponseBuilder::json(false, null, $e->getMessage());
                    }
                }
                return ResponseBuilder::json(false, null, "INVOICE EMPTY!");
            }
            return ResponseBuilder::json(false, null, "MISSING PARAMS!");
        }
        return ResponseBuilder::json(false, null, "METHOD ALLOW POST!");
    }

    public function actionDelete()
    {
        $request = Yii::$app->request;
        if ($request->isPost) {
            $id = $request->post('id');
            if (!empty($id)) {
                $invoice = StockInvoice::find()->where(['id' => $id])->one();
                if (!empty($invoice)) {
                    $transaction = Yii::$app->db->beginTransaction();
                    try {
                        $items = $invoice->items ?? [];
                        foreach ($items as $invoiceItem) {
                            $item = Item::find()->where(['id' => $invoiceItem->product_id])->one();
                            if (!empty($item)) {
                                if ($invoice->type == StockInvoice::TYPE_IN) {
                                    $item->stock -= $invoiceItem->quantity;
                                } elseif ($invoice->type == StockInvoice::TYPE_OUT || $invoice->type == StockInvoice::TYPE_DESTROY) {
                                    $item->stock += $invoiceItem->quantity;
                                }
                                $item->save(false);
                            }
                        }

                        // StockInvoiceItem::deleteAll(['invoice_id' => $invoice->id]); // Giữ nguyên comment
                        $invoice->status = StockInvoice::STATUS_DELETED;
                        $invoice->save(false);

                        $transaction->commit();
                        return ResponseBuilder::json(true, $invoice, "DELETE SUCCESS!");
                    } catch (\Throwable $e) {
                        $transaction->rollBack();
                        return ResponseBuilder::json(false, null, $e->getMessage());
                    }
                }
                return ResponseBuilder::json(false, null, "INVOICE EMPTY!");
            }
            return ResponseBuilder::json(false, null, "MISSING PARAMS!");
        }
        return ResponseBuilder::json(false, null, "METHOD ALLOW POST!");
    }

    public function actionView(int $id)
    {
        $request = Yii::$app->request;
        if ($request->isGet) {
            $id = $request->get('id');
            if (!empty($id)) {
                $invoice = StockInvoice::find()->where(['id' => $id])->one();
                if (!empty($invoice)) {
                    return ResponseBuilder::json(true, $invoice, "GET SUCCESS! ");
                }
                return ResponseBuilder::json(false, $invoice->getErrors(), "DATA EMPTY! ");
            }
            return ResponseBuilder::json(false, null, "MISING PARAMS! ");
        }
        return ResponseBuilder::json(false, null, "METHOD ALLOW GET! ");
    }

    public function actionIndex()
    {
        return ResponseBuilder::json(true, (new StockInvoiceSearch())->search(Yii::$app->request->queryParams));
    }
}
