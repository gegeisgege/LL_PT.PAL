<?php

namespace App\Http\Controllers;

use App\Models\Attachment;
use App\Models\AuditLog;
use Illuminate\Support\Facades\Storage;

class AttachmentController extends Controller
{
    public function download(Attachment $attachment)
    {
        $this->authorize('view', $attachment->lesson);

        AuditLog::record('ATTACHMENT_DOWNLOADED', $attachment);

        return Storage::disk('local')->download(
            $attachment->storage_path,
            $attachment->original_filename
        );
    }
}