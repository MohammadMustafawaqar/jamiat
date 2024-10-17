<?php

namespace App\Observers;

use App\Models\Log;
use Illuminate\Support\Facades\Auth;

class UserActionObserver
{
    public function created($model)
    {
        $this->logAction('created', $model);
    }

    public function updated($model)
    {
        $this->logAction('updated', $model);
    }

    public function deleted($model)
    {
        $this->logAction('deleted', $model);
    }

    private function logAction($action, $model)
    {
        $log = [
            'user_id' => Auth::id(),
            'action' => $action,
            'description' => $this->getDescription($action, $model),
            'model_type' => get_class($model),
            'model_id' => $model->id,
        ];
        Log::create($log);
    }

    private function getDescription($action, $model)
    {
        if ($action === 'updated') {
            $changes = $model->getChanges();

            $original = array_intersect_key($model->getOriginal(), $changes);
            $originalJson = json_encode($original, JSON_PRETTY_PRINT);
            $changesJson = json_encode($changes, JSON_PRETTY_PRINT);

            return sprintf(
                'User %s updated a record in %s with ID %s. Original: %s, Changes: %s',
                Auth::user()->name,
                get_class($model),
                $model->id,
                $originalJson,
                $changesJson
            );
        }

        return sprintf(
            'User %s %s a record in %s with ID %s',
            Auth::id(),
            $action,
            get_class($model),
            $model->id
        );
    }
}
