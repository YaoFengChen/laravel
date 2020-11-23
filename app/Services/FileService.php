<?php

namespace App\Services;

use App\Repository\FileRepository;

class FileService
{
    private $fileRepository;

    public function __construct(FileRepository $fileRepository)
    {
        $this->fileRepository = $fileRepository;
    }

    public function getFile($id)
    {
        return $this->fileRepository->getNameWithId($id);
    }
}
