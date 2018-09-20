<?php
if(!function_exists('getTypeByExt')){
    function getTypeByExt($ext){
        $ext = strtolower($ext);

        if(in_array($ext, unserialize(AUTHORIZED_PICTURE_TYPE))){
            $file_type = 'picture';
        }
        elseif(in_array($ext, unserialize(AUTHORIZED_VIDEO_TYPE))){
            $file_type = 'video';
        }
        elseif(in_array($ext, unserialize(AUTHORIZED_AUDIO_TYPE))){
            $file_type = 'music';
        }
        elseif(in_array($ext, unserialize(AUTHORIZED_DOCUMENT_TYPE))){
            $file_type = 'document';
        }
        elseif(in_array($ext, unserialize(AUTHORIZED_OTHER_TYPE))){
            $file_type = 'other';
        }
        else {
            $file_type = null;
        }
        return $file_type;
    }
}