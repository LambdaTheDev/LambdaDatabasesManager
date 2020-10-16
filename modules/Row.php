<?php


class Row
{
    public $field;
    public $type;
    public $isNull;
    public $key;
    public $default;
    public $extra;

    /**
     * Row constructor.
     * @param $field
     * @param $type
     * @param $isNull
     * @param $key
     * @param $default
     * @param $extra
     */
    public function __construct($field, $type, $isNull, $key, $default, $extra)
    {
        $this->field = $field;
        $this->type = $type;
        $this->isNull = $isNull;
        $this->key = $key;
        $this->default = $default;
        $this->extra = $extra;
    }
}