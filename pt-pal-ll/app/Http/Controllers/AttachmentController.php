<?php

namespace App\Http\Controllers;

use App\Models\Attachment;
use Illuminate\Support\Facades\Storage;

class AttachmentController extends Controller
{
    public function download(Attachment $attachment)
    {
        $this->authorize('view', $attachment->lesson);

        return Storage::disk('local')->download(
            $attachment->storage_path,
            $attachment->original_filename
        );
    }
}