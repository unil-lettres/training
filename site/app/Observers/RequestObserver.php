<?php

namespace App\Observers;

use App\Models\Request;
use Illuminate\Support\Facades\Storage;

class RequestObserver
{
    /**
     * Handle the Request "created" event.
     */
    public function created(Request $request): void
    {
        //
    }

    /**
     * Handle the Request "updated" event.
     */
    public function updated(Request $request): void
    {
        if ($request->isDirty('file') && $request->getOriginal('file')) {
            Storage::disk('public')
                ->delete($request->getOriginal('file'));
        }
    }

    /**
     * Handle the Request "deleted" event.
     */
    public function deleted(Request $request): void
    {
        if (! is_null($request->file)) {
            Storage::disk('public')
                ->delete($request->file);
        }
    }

    /**
     * Handle the Request "restored" event.
     */
    public function restored(Request $request): void
    {
        //
    }

    /**
     * Handle the Request "force deleted" event.
     */
    public function forceDeleted(Request $request): void
    {
        //
    }
}