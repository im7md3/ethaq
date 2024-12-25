<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attachment extends Model
{
    use HasFactory;
    protected $fillable = ['file_type', 'file_id', 'path', 'size', 'mime'];
    protected $appends = ['type'];
    public function file()
    {
        return $this->morphTo();
    }
    public static function store($file, $obj)
    {
        $path = store_file($file, 'attachments');
        $mime = $file->getMimeType();
        $size = $file->getSize();
        $obj->files()->create(compact('path', 'mime', 'size'));
    }
    public function getTypeAttribute()
    {
        $mime = $this->mime;
        $path = $this->path;
        if (str_contains($mime, 'audio') or str_contains($path, '.m4a') or str_contains($mime, 'empty')) {
            return 'audio';
        }elseif (str_contains($mime, 'video')) {
            return 'video';
        }elseif (str_contains($mime, 'application')) {
            return 'pdf';
        } elseif (str_contains($mime, 'image')) {
            return 'img';
        } 
    }
    public function getSizeAttribute($value)
    {
        return $this->formatSizeUnits($value);
    }

    function formatSizeUnits($bytes)
    {
        if ($bytes >= 1073741824)
        {
            $bytes = number_format($bytes / 1073741824, 2) . ' GB';
        }
        elseif ($bytes >= 1048576)
        {
            $bytes = number_format($bytes / 1048576, 2) . ' MB';
        }
        elseif ($bytes >= 1024)
        {
            $bytes = number_format($bytes / 1024, 2) . ' KB';
        }
        elseif ($bytes > 1)
        {
            $bytes = $bytes . ' bytes';
        }
        elseif ($bytes == 1)
        {
            $bytes = $bytes . ' byte';
        }
        else
        {
            $bytes = '0 bytes';
        }

        return $bytes;
}

}
