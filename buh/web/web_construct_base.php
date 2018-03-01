<?php
namespace main\web;


class tag_double
{
    private $tag;
    private $params;
    private $internal;

    public function __construct($tag, array $params = [], $internal = null)
    {
        $this->tag=$tag;
        $quote="\"";
        foreach ($params as $key => $value) {
            $this->params = $this->params . " " . $key . "=" . $quote . $value . $quote;
        }
        $this->addInternal($internal);

        // $this->internal=trim(implode($internal));
    }
    public function addInternal($internal)
    {
        if ($internal != null && is_array($internal)) {
            foreach ($internal as $value) {
                if (is_object($value)) {
                    $this->internal = $this->internal . $value->getHtml();
                } else {
                    $this->internal = $this->internal . $value;
                }
            }
        }
    }
    public function getHtml()
    {
        return "<" . $this->tag . $this->params . ">" . $this->internal . "</" . $this->tag . ">";
    }
}


class tag_simple
{
    private $tag;
    private $params;


    public function __construct($tag, array $params)
    {
        $this->tag=$tag;
        $quote="\"";

        foreach ($params as $key => $value) {
            $this->params = $this->params . " " . $key . "=" . $quote . $value . $quote;
        }

        $this->params=trim($this->params);
    }
    public function getHtml()
    {
        $quote="\"";
        return "<" . $this->tag . " " . $this->params . ">\n";
    }
}




class web_build {
  public function __construct($string) {

  }
}
