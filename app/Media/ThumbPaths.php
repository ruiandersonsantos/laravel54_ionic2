<?php


namespace CodeFlix\Media;


trait ThumbPaths
{
    use VideoStorages;

    public function getThumbRelativeAttribute(){
        return $this->thumb ? "{$this->thumb_folder_storage}/{$this->thumb}":false;
    }

    public function getThumbPathAttribute(){
        if($this->thumb_relative){
            return $this->getAbsolutePath($this->getStorage(),$this->thumb_relative);
        }
        return false;
    }

    public function getThumbSmallRelativeAttribute(){
        if($this->thumb){
            list($name, $extesion) = explode('.',$this->thumb);
            return "{$this->thumb_folder_storage}/{$name}_small.{$extesion}";
        }
       return false;
    }

    public function getThumbSmallPathAttribute(){
        if($this->thumb_relative){
            return $this->getAbsolutePath($this->getStorage(),$this->thumb_small_relative);
        }
        return false;
    }




}