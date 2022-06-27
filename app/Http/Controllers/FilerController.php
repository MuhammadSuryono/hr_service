<?php

namespace App\Http\Controllers;

use App\Http\Requests\FilerRequest;
use App\Interfaces\FilerInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class FilerController extends Controller
{
    protected FilerInterface $filer;

    protected Request $request;

    public function __construct(FilerInterface $filer, Request $request)
    {
        $this->filer = $filer;
        $this->request = $request;
    }

    public function storeAttachment(): JsonResponse
    {
        $resp = $this->filer->uploadFile();
        return $this->callback_response($resp->status, $resp->code, $resp->message, $resp->data);
    }
}
