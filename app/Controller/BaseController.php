<?php

namespace Api\Controller;

use Api\Core\Response;

class BaseController extends \Api\Core\App
{
	public function __call($name, $arguments)
	{
		Response::sent(501);
	}

    public function uriSegment($index = 0)
    {
        if (isset($_GET['url']))
        {
            $url = filter_var($_GET['url'], FILTER_SANITIZE_URL);
            $url = trim($url, '/');
            $url = explode('/', $url);
            if (isset($url[$index])){
                return $url[$index];
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function getStreamData()
    {
        parse_str(file_get_contents("php://input"), $post_vars);
        if (empty($post_vars)){
            Response::sent(400, ["error_message" => "empty post data"]);
        }
        return $post_vars;
    }
}