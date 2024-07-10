<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Storage;

class FileUploadService
{
    public static function uploadFileImage($file_image, $voterId){
        $old_image = User::find($voterId)->profile_image;
        $image_name = 'profile_image-'.rand(11111111,99999999).'.'.$file_image->getClientOriginalExtension();
        
        $path = $file_image->storeAs('public/uploaded/images', $image_name);

        if ($old_image != 'profile_default.png') {
            Storage::delete('public/uploaded/images/'.$old_image);
        }
        
        return $image_name;
    }

    
}
