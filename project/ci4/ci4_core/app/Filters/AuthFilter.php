<?php namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class AuthFilter implements FilterInterface
{
	public function before(RequestInterface $request, $params = null)
    {
        // if (!$_COOKIE["isLogin"])
	    // {
	    // 	echo "invalid";
	    //     return redirect()->to(base_url('login'))->with('error', "Invalid Credential");
	    // }

    	//if (!session()->has('isLogin'))
	    //{
	    //	echo "invalid";
	    //    return redirect()->to(base_url('login'))->with('error', "Invalid Credential");
	    //}
        // Do something here
    }

    //--------------------------------------------------------------------

	public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Do something here
    }
}