<?php

namespace App\Repository;

use App\Model\Files;

class FileRepository
{
    public function getNameWithId($id)
    {
        return Files::select('name')->where('id', $id)->first();
    }
}
