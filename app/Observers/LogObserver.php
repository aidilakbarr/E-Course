<?php

namespace App\Observers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class LogObserver
{
    public function created(Model $model)
    {
        Log::channel('activity')->info('Created ' . $model->getTable(), [
            'user_id' => Auth::id(),
            'data' => $model->getAttributes(),
        ]);
    }

    public function updated(Model $model)
    {
        Log::channel('activity')->info('Updated ' . $model->getTable(), [
            'user_id' => Auth::id(),
            'original' => $model->getOriginal(),
            'changes' => $model->getChanges(),
        ]);
    }

    public function deleted(Model $model)
    {
        Log::channel('activity')->info('Deleted ' . $model->getTable(), [
            'user_id' => Auth::id(),
            'data' => $model->getOriginal(),
        ]);
    }
}
