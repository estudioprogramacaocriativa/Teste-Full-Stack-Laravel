<?php

namespace App\Helpers;

use App\Functions;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class FileManager
{
    public static function upload($model, $file, $folder, $id, $column_name, $parameters = [], $update = true)
    {
        if(empty($file)):
            return false;
        endif;

        $file_type = getimagesize($file);
        $file_extension = $file->extension();
        $prefix = $parameters['prefix'] ?? null;
        $filename = $file->getClientOriginalName();
        $directory = Storage::disk('public')->getDriver()->getAdapter()->getPathPrefix() . $folder;

        if(isset($parameters['current'])):
            self::destroy($folder, $parameters['current']);
        endif;

        if (!file_exists($directory)):
            File::makeDirectory($directory, 0777, true);
        endif;

        Storage::putFileAs($folder, $file, $filename);

        if(!$file_type):
            $file_path_info = pathinfo($file->getClientOriginalName(),PATHINFO_FILENAME);
            $filename = $prefix . Functions::friendlyUrl($file_path_info) . '.' . $file_extension;
            Storage::putFileAs($folder, $file, $filename);
        endif;

        if(!$update):
            return $filename;
        else:
            $model::find($id)->update([$column_name => $filename]);
        endif;
    }

    public static function destroy($folder, $path)
    {
        $files = Storage::allFiles($folder);
        $file = "{$folder}/{$path}";

        if(in_array($file, $files) && Storage::disk('public')->exists($file) && !is_dir($file)):
            Storage::delete($file);
        endif;

        if(empty(Storage::allFiles($folder))):
            Storage::deleteDirectory($folder);
        endif;
    }

    public static function isValidFile($folder, $file)
    {
        $files = Storage::allFiles($folder);
        $path = "{$folder}/{$file}";

        if(in_array($path, $files) && Storage::disk('public')->exists($path) && !is_dir($path)):
            return true;
        endif;

        return false;
    }

    public static function get($filename, $folder, $tim = [], $default = 'no-image.jpg')
    {
        $target_file = "storage/{$folder}/{$filename}";
        $default = "images/{$default}";

        if(isset($tim['tim'])):
            $target_file = self::tim("storage/{$folder}/{$filename}", $tim['tim']['w'] ?? null, $tim['tim']['h'] ?? null, $tim['tim']['q'] ?? null, $tim['tim']['c'] ?? null);
            $default = self::tim($default, $tim['tim']['w'] ?? null, $tim['tim']['h'] ?? null, $tim['tim']['q'] ?? null, $tim['tim']['c'] ?? null);
        endif;

        $check_file = Storage::disk('public')->exists("{$folder}/{$filename}");

        if($check_file && !is_dir($check_file) && !empty($filename)):
            $file_path = asset($target_file);
        else:
            $file_path = asset($default);
        endif;

        return $file_path;
    }

    public static function tim($path, $width = null, $height = null, $quality = null, $crop = null) {
        $url = url('/') . '/tim.php?src=' . $path;

        if (isset($width)):
            $url .= '&w=' . $width;
        endif;

        if (isset($height) && $height > 0):
            $url .= '&h=' . $height;
        endif;

        if (isset($crop)):
            $url .= '&zc=' . $crop;
        else:
            $url .= '&zc=1';
        endif;

        if (isset($quality)):
            $url .= '&q=' . $quality . '&s=1';
        else:
            $url .= '&q=95&s=1';
        endif;

        return $url;
    }
}
