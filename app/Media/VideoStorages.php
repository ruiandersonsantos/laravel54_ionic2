<?php

namespace CodeFlix\Media;

use Illuminate\Filesystem\FilesystemAdapter;

trait VideoStorages
{
    /**
     * @return \Illuminate\Filesystem\FilesystemAdapter
     */
    public function getStorage(){
        return \Storage::disk($this->getDiskDriver());
    }

    protected function getDiskDriver(){
        return config('filesystems.default');
    }

    /**
     * @param FilesystemAdapter $storage
     * @param $fileRelativePath
     * @return mixed
     */
    protected function getAbsolutePath(FilesystemAdapter $storage, $fileRelativePath){
        return $storage->getDriver()->getAdapter()->applyPathPrefix($fileRelativePath);
    }
}