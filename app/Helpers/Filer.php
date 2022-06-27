<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Storage;

class Filer
{
    /**
     * @var string $directory
     */
    public static string $publicDirectory = 'public/files/';

    /**
     * @param $request
     * @param string $inputName
     * @return string
     */
    public static function uploadFile($request, string $inputName = 'file'): string
    {
        $requestFile = $request->file($inputName);
        try {
            $filename = time().'.'.$requestFile->extension();
            Storage::putFileAs(self::$publicDirectory, $requestFile, $filename);
            return asset(Storage::url(self::$publicDirectory.$filename));
        } catch (\Throwable $th) {
            report($th);
            abort(500, 'Error uploading file: ');
        }
    }
}
