<?php

namespace App\Repositories;

use App\Helpers\Filer;
use App\Interfaces\FilerInterface;

class FilerRepository extends Controller implements FilerInterface
{
    public function uploadFile($inputname = 'file'): object
    {
        if (request()->hasFile($inputname)) {
            $filePath = Filer::uploadFile(request(), $inputname);
            return $this->callback_response("success", 200, 'Upload file success', [
                'file_path' => $filePath
            ]);
        }
        return $this->callback_response("error", 400, 'Upload file failed, attachment is required');
    }
}
