<?php

namespace app\components\filekit;

use Yii;
use trntv\filekit\File;
use yii\helpers\FileHelper;
use trntv\filekit\Storage as BaseStorage;

class Storage extends BaseStorage
{
    public function save($file, $preserveFileName = false, $overwrite = false, $config = [], $pathPrefix = ''): bool|string
    {
        $pathPrefix = FileHelper::normalizePath($pathPrefix);
        $fileObj = File::create($file);
        $dirIndex = $this->getDirIndex($pathPrefix);
        if ($preserveFileName === false) {
            do {
                $filename = implode('.', [
                    Yii::$app->security->generateRandomString(),
                    $fileObj->getExtension()
                ]);
                $path = implode(DIRECTORY_SEPARATOR, array_filter([$pathPrefix, $dirIndex, $filename]));
            } while ($this->getFilesystem()->has($path));
        } else {
            $filename = $fileObj->getPathInfo('filename');
            $path = implode(DIRECTORY_SEPARATOR, array_filter([$pathPrefix, $dirIndex, $filename]));
        }

        $this->beforeSave($fileObj->getPath(), $this->getFilesystem());

        $stream = fopen($fileObj->getPath(), 'r+');

        $defaultConfig = $this->defaultSaveConfig;

        if (is_callable($defaultConfig)) {
            $defaultConfig = call_user_func($defaultConfig, $fileObj);
        }

        if (is_callable($config)) {
            $config = call_user_func($config, $fileObj);
        }

        $config = array_merge(['ContentType' => $fileObj->getMimeType()], $defaultConfig, $config);

        if ($overwrite) {
            $success = $this->getFilesystem()->putStream($path, $stream, $config);
        } else {
            $success = $this->getFilesystem()->writeStream($path, $stream, $config);
        }

        if (is_resource($stream)) {
            fclose($stream);
        }

        if ($success) {
            $this->afterSave($path, $this->getFilesystem());
            return $path;
        }

        return false;
    }
}

