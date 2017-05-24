<?php

namespace CodeFlix\Media;

trait VideoPaths
{
    use ThumbPaths;

    public function getThumbFolderStorageAttribute(){
        return "videos/{$this->id}";
    }

    public function getFileFolderStorageAttribute(){
        return "videos/{$this->id}";
    }

    public function getThumbAssetAttribute(){
        //return route('admin.series.thumb_asset',['serie'=>$this->id]);
    }

    public function getThumbSmallAssetAttribute(){
       // return route('admin.series.thumb_small_asset',['serie'=>$this->id]);
    }

    public function getThumbDefaultAttribute(){
        return env('VIDEO_NO_THUMB');
    }

    public function getFileRelativeAttribute(){
        return $this->file ? "{$this->file_folder_storage}/{$this->file}":false;
    }

    public function getFilePathAttribute(){
        return $this->getAbsolutePath($this->getStorage(),$this->file_relative);
    }
}