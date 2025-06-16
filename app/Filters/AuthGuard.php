<?php
namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class AuthGuard implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $session = session();

        // Use $request->getUri() instead of $request->uri
        if ($request->getUri()->getPath() === 'logout') {
            return;
        }
        
        // Completely destroy any invalid session
        if ($session->get('isLoggedIn') && !$session->get('user')) {
            $session->destroy();
            return redirect()->to('/login')->withCookies();
        }
        
        if (!$session->get('isLoggedIn')) {
            return redirect()->to('/login')
                ->withHeaders([
                    'Cache-Control' => 'no-store, no-cache, must-revalidate',
                    'Pragma' => 'no-cache'
                ]);
        }
        
        // Verify session consistency
        if ($session->get('lastActivity') && (time() - $session->get('lastActivity') > 3600)) {
            $session->destroy();
            return redirect()->to('/login')->withCookies();
        }
        // Update last activity
        $session->set('lastActivity', time());
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // No action needed
    }
}