<?php
/**
 * Created by PhpStorm.
 * User: ruianderson
 * Date: 23/05/2017
 * Time: 21:36
 */

namespace CodeFlix\Media;


use Illuminate\Http\UploadedFile;

trait Uploads
{
    protected function upload($model, UploadedFile $file, $type){
        /** @var FilesystemAdapter $storage */
        $storage = $model->getStorage();

        $name = md5(time()."{$model->id}-{$file->getClientOriginalName()}") . ".{$file->guessExtension()}";

        $result = $storage->putFileAs($model->{"{$type}_folder_storage"},$file,$name);

        return $result ? $name : $result;
    }

}