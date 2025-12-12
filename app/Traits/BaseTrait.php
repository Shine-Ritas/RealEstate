<?php

namespace App\Traits;

trait BaseTrait
{
    public string $toDelete = '';

    public function setToDelete($id): void
    {
        $this->toDelete = $id;
    }
}
