<?php


class Post
{
    private $url;
    private $data;
    private $result;

    /**
     * Post constructor.
     * @param $url
     * @param $data
     */
    public function __construct($url, $data)
    {
        $this->url = $url;
        $this->data = $data;
        $this->execute();
    }

    private function execute()
    {
        $options = array(
            'http' => array(
                'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
                'method'  => 'POST',
                'content' => http_build_query($this->data)
            )
        );

        $context  = stream_context_create($options);
        $this->result = file_get_contents($this->url, false, $context);
    }

    public function getResult()
    {
        if(!$this->result)
        {
            return null;
        }
        return $this->result;
    }
}