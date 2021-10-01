<?php


namespace Kernel;


class Request
{
    private $url;
    private $get;
    private $post;

    public function __construct()
    {
        $this->url = trim($_SERVER['REQUEST_URI'], '/');
        $this->get = $_GET;
        $this->post = $_POST;
    }

    /**
     * @return mixed
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @param mixed $url
     * @return Request
     */
    public function setUrl($url)
    {
        $this->url = $url;
        return $this;
    }

    /**
     * @return array
     */
    public function getGet()
    {
        return $this->get;
    }

    /**
     * @param array $get
     * @return Request
     */
    public function setGet($get)
    {
        $this->get = $get;
        return $this;
    }

    /**
     * @return array
     */
    public function getPost()
    {
        return $this->post;
    }

    /**
     * @param array $post
     * @return Request
     */
    public function setPost($post)
    {
        $this->post = $post;
        return $this;
    }


}