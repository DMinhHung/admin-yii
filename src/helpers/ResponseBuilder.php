<?php

namespace app\helpers;

use JetBrains\PhpStorm\ArrayShape;
use yii\data\DataProviderInterface;
use yii\rest\Serializer;
use yii\web\HttpException;

class ResponseBuilder
{
    /**
     * @throws HttpException
     */
    #[ArrayShape(["status" => "bool", "data" => "mixed", "messages" => "string", "code" => "int"])] public static function json(bool $status = true, $data = null, string $message = "", int $code = 200): array
    {
        if ($code != 200) {
            throw new HttpException($code, $message, $code);
        }
        if ($data instanceof DataProviderInterface) {
            $serializer = new Serializer(['collectionEnvelope' => 'items']);
            $data = $serializer->serialize($data);
        }
        return [
            "status" => $status,
            "data" => $data,
            "messages" => $message,
            "code" => $code
        ];
    }
}