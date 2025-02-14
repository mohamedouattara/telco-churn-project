<?php


namespace App\Services;

use Symfony\Component\HttpFoundation\File\UploadedFile;

class FileUploader
{
    private $targetDirectory;
    /**
     * FileUploader constructor.
     * @param $targetDirectory
     */
    public function __construct($targetDirectory)
    {
        $this->targetDirectory = $targetDirectory;
    }
    public function upload(UploadedFile $file)
    {
        $filename = md5(uniqid()) . '.' . $file->guessExtension();
        $file->move($this->targetDirectory, $filename);
        return $filename;
    }
}