<?php

namespace app\modules\v1\general\controllers;

use Yii;
use yii\rest\Controller;
use yii\web\UploadedFile;
use yii\web\HttpException;
use app\helpers\ResponseBuilder;
use app\modules\v1\general\models\form\UploadForm;

class UploadController extends Controller
{
    /**
     * @throws \Exception
     * @throws HttpException
     */
    public function actionCreate(): array
    {
        $request = Yii::$app->request;
        if ($request->isPost) {
            $file = UploadedFile::getInstanceByName('file');
            if (!empty($file)) {
                $objectKey = 'uploaded_files/' . uniqid() . '.' . $file->extension;
                $uploadService = new UploadForm();
                $uploadService->file = $file;
                $data = $uploadService->uploadFileToS3($objectKey);

                if (!empty($data)) {
                    $url = $uploadService->assetUrl;
                    $deleteUrl = '/api/v1/end-user/feedback-ticket/ticket/delete-upload?path=' . $objectKey;
                    return ResponseBuilder::json(true, [
                        'name' => $file->name,
                        'type' => $file->extension,
                        'base_url' => env("STORAGE_URL"),
                        'path' => $objectKey,
                        'url' => $url,
                        'delete_url' => $deleteUrl
                    ], "Upload success.");
                } else {
                    return ResponseBuilder::json(false, [], "Upload failed.");
                }
            }
            return ResponseBuilder::json(false, [], "No file uploaded.");
        }
        return ResponseBuilder::json(false, [], "Only POST allowed!");
    }

    /**
     * @throws HttpException
     */
    public function actionDelete(): array
    {
        $request = Yii::$app->request;
        if ($request->isPost) {
            $objectKey = $request->post('path');
            if (!empty($objectKey)) {
                $uploadService = new UploadForm();
                $uploadService->deleteFileFromS3($objectKey);
                return ResponseBuilder::json(true, [], "Delete success.");
            }
            return ResponseBuilder::json(false, [], 'Delete fail');
        }
        return ResponseBuilder::json(false, [], "Only POST allowed!");
    }
}
