<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class Upload extends BaseConfig
{
    // Directory where files will be saved (outside public folder)
    public $uploadPath = WRITEPATH . 'uploads';
    
    // Allowed file extensions (case insensitive)
    public $allowedTypes = 'jpg,jpeg,png,pdf,doc,docx,PDF,JPG,JPEG,PNG,DOC,DOCX';
    
    // Maximum file size in KB (2MB)
    public $maxSize = 5120; // 5MB for flexibility, adjust as needed
    
    // Encrypt filenames for security
    public $encryptName = true;
    
    // Explicit MIME types for better validation
    public $mimeTypes = [
        'jpg'  => ['image/jpeg', 'image/pjpeg'],
        'jpeg' => ['image/jpeg', 'image/pjpeg'],
        'png'  => 'image/png',
        'pdf'  => ['application/pdf', 'application/x-pdf'],
        'doc'  => 'application/msword',
        'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'
    ];
    
    // Additional security settings
    public $detectMime = true; // Detect MIME type from file content
    public $fileExt = 'webp'; // If image conversion is needed
}