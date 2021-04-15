<?php


class Column
{
    public string $field;
    public string $type;
    public string $collation;
    public string $null;
    public ?string $key;
    public ?string $default;
    public ?string $extra;


    public function __construct(string $field, string $type, string $collation, bool $null, ?string $key, ?string $default, ?string $extra)
    {
        $this->field = $field;
        $this->type = $type;
        $this->collation = $collation;
        $this->key = $key;
        $this->default = $default;
        $this->extra = $extra;

        if($null) $this->null = 'YES';
        else $this->null = 'NO';
    }

    public function isNull() : bool
    {
        return $this->null == 'YES';
    }
}