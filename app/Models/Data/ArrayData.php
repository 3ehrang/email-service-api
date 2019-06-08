<?php

namespace App\Models\Data;

abstract class ArrayData
{

    /**
     * Array of email sending data key and value
     *
     * @var array
     */
    protected $attributes ;

    /**
     * Array of The attributes that are assignable.
     *
     * @var array
     */
    protected $fillable;

    /**
     * EmailData constructor.
     *
     * @param array $attributes
     *
     * @throws \Exception
     */
    public function __construct($attributes = [])
    {
        if ($attributes) {
            foreach ($attributes as $key => $value) {
                $this->setAttribute($key, $value);
            }
        }
    }

    /**
     * Set attribute by getting key and value
     *
     * @param $key
     * @param $value
     *
     * @return $this
     * @throws \Exception
     */
    public function setAttribute($key, $value)
    {
        $this->attributes[$key] = $value;

        return $this;
    }

    /**
     * @param $key
     *
     * @return mixed
     * @throws \Exception
     */
    public function getAttribute($key)
    {
        if (!$this->isKeyExist($key)) {

            throw new \Exception(' Unknown key ' . $key . ' in list');

        }

        return $this->attributes[$key];
    }

    /**
     * Get all attributes in array format
     * Only return values defined in fillable data
     *
     * @return array
     */
    public function toArray()
    {
        $data = [];

        foreach ($this->attributes as $key => $value) {
            if ($this->isKeyExist($key)) {
                $data[$key] = $value;
            }
        }
        return $data;
    }

    /**
     * Check too see if a key is defined in fillable array or not
     *
     * @param $key
     *
     * @return bool
     */
    public function isKeyExist($key)
    {
        return in_array($key, $this->fillable);
    }

    /**
     * Dynamically set attributes on the model.
     *
     * @param $key
     * @param $value
     *
     * @return $this
     * @throws \Exception
     */
    public function __set($key, $value)
    {
        return $this->setAttribute($key, $value);
    }

    /**
     * Dynamically retrieve attributes on the model.
     *
     * @param  string  $key
     *
     * @return mixed
     * @throws \Exception|
     */
    public function __get($key)
    {
        return $this->getAttribute($key);
    }

    /**
     * Determine if an attribute exists on the model.
     *
     * @param  string  $key
     * @return bool
     */
    public function __isset($key)
    {
        return isset($this->attributes[$key]);
    }

}
