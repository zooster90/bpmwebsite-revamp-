<?php

namespace App\Traits;

use Intervention\Image\Laravel\Facades\Image;

trait CompressesImages
{
  
    public static function bootCompressesImages(): void
    {
        static::saved(function ($model) {
         
            $fields = $model->compressibleImages ?? [];

            foreach ($fields as $field) {
               
                if ($model->isDirty($field) && !empty($model->$field)) {
                    $path = storage_path('app/public/' . $model->$field);

                    if (file_exists($path)) {
                        $image = Image::read($path);
                        
                     
                        $image->scale(width: 1600);
                        
                        $image->save(quality: 75);
                    }
                }
            }
        });
    }
}