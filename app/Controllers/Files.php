<?php

namespace App\Controllers;

use App\Models\FileModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class Files extends BaseController
{
    protected $helpers = ['form', 'file'];

    public function index()
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login');
        }

        $model = new FileModel();
        $data = [
            'files' => $model->getAllFiles(),
            'is_admin' => session('user.role') === 'admin',
            'title' => session('user.role') === 'admin' ? 'All Files' : 'My Files'
        ];

        return view('files/index', $data);
    }

    public function upload()
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login');
        }

        $data['title'] = 'Upload File';
        return view('files/upload', $data);
    }

    public function store()
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login');
        }

        $validationRule = [
            'userfile' => [
                'label' => 'File',
                'rules' => [
                    'uploaded[userfile]',
                    'mime_in[userfile,image/jpg,image/jpeg,image/png,application/pdf,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document]',
                    'ext_in[userfile,jpg,jpeg,png,pdf,doc,docx]',
                    'max_size[userfile,5120]',
                ],
                'errors' => [
                    'uploaded' => 'Please select a file to upload',
                    'max_size' => 'The file is too large (max 5MB)',
                    'mime_in' => 'Allowed file types: JPG, PNG, PDF, DOC, DOCX',
                    'ext_in' => 'Invalid file extension'
                ]
            ]
        ];

        if (!$this->validate($validationRule)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $file = $this->request->getFile('userfile');
        $newName = $file->getRandomName();
        
        if (!$file->hasMoved()) {
            $file->move(WRITEPATH . 'uploads', $newName);
        }

        $model = new FileModel();
        $model->save([
            'user_id' => session()->get('user')['id'],
            'filename' => $newName,
            'original_name' => $file->getClientName(),
            'file_type' => $file->getClientMimeType(),
            'file_size' => $file->getSize()
        ]);

        // Log file upload activity
        model('ActivityModel')->insert([
            'user_id' => session('user.id'),
            'activity_type' => 'file_upload',
            'details' => 'Uploaded file: ' . $file->getClientName(),
            'ip_address' => $this->request->getIPAddress()
        ]);

        return redirect()->to('/files')->with('success', 'File uploaded successfully');
    }

    public function download($id)
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login');
        }

        $model = new FileModel();
        $file = $model->find($id);

        if (!$file || $file['user_id'] != session()->get('user')['id']) {
            throw PageNotFoundException::forPageNotFound();
        }

        $filepath = WRITEPATH . 'uploads/' . $file['filename'];
        
        if (!file_exists($filepath)) {
            throw PageNotFoundException::forPageNotFound();
        }

        return $this->response->download($filepath, null)->setFileName($file['original_name']);
    }

    public function view($id)
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login');
        }

        $model = new FileModel();
        $file = $model->find($id);

        // Allow access if admin OR file owner
        if (!$file || (session('user.role') !== 'admin' && $file['user_id'] != session('user.id'))) {
            throw PageNotFoundException::forPageNotFound();
        }

        $filePath = WRITEPATH . 'uploads/' . $file['filename'];
        
        if (!file_exists($filePath)) {
            throw PageNotFoundException::forPageNotFound();
        }

        // Improved file handling
        $mime = $file['file_type'];
        $contents = file_get_contents($filePath);

        // Special handling for PDFs to display in browser
        if ($mime === 'application/pdf') {
            return $this->response
                ->setHeader('Content-Type', $mime)
                ->setHeader('Content-Disposition', 'inline; filename="' . $file['original_name'] . '"')
                ->setBody($contents);
        }

        // For images
        if (strpos($mime, 'image/') === 0) {
            return $this->response
                ->setHeader('Content-Type', $mime)
                ->setBody($contents);
        }

        // Default download for other types
        return $this->response->download($filePath, null)->setFileName($file['original_name']);
    }

   public function delete($id)
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login');
        }

        $model = new FileModel();
        $file = $model->find($id);

        if (!$file || (session('user.role') !== 'admin' && $file['user_id'] != session()->get('user')['id'])) {
            throw PageNotFoundException::forPageNotFound();
        }

        $filepath = WRITEPATH . 'uploads/' . $file['filename'];
        
        if (file_exists($filepath)) {
            unlink($filepath);
        }

        // Log file deletion activity
        model('ActivityModel')->insert([
            'user_id' => session('user.id'),
            'activity_type' => 'file_delete',
            'details' => 'Deleted file: ' . $file['original_name'],
            'ip_address' => $this->request->getIPAddress()
        ]);

        $model->delete($id);

        return redirect()->to('/files')->with('success', 'File deleted successfully');
    }
}