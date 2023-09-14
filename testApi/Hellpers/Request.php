<?php

class Request
{
    const METHOD_GET = 1;

    /**
     * @var static
     */
    protected static $instance;

    /**
     * @return self
     */
    public static function i()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * @param      $key
     * @param null $default_value
     * @param null $max_value
     *
     * @return int|null
     */
    public function getInt($key, $default_value = null, $max_value = null)
    {
        return $this->getParamInt($key, self::METHOD_GET, $default_value, $max_value);
    }

    /**
     * @param $key
     * @param $default_value
     * @param $max_value
     *
     * @return mixed|string|null
     */
    public function getString($key, $default_value = null, $max_value = null)
    {
        return $this->getParamString($key, self::METHOD_GET, $default_value, $max_value,2);
    }

    /**
     * @param $key
     * @param $default_value
     * @param $max_value
     *
     * @return float|int|mixed|string|null
     */
    public function getFloat($key, $default_value = null, $max_value = null)
    {
        return $this->getParamFloat($key, self::METHOD_GET, $default_value, $max_value);
    }

    /**
     * @param $key
     * @param $source
     * @param $default_value
     * @param $max_value
     *
     * @return float|int|mixed|string|null
     */
    protected function getParamFloat($key, $source = self::METHOD_GET, $default_value = null, $max_value = null)
    {
        $value = $this->getParam($key, $source);
        $value = str_replace(',', '.', $value);
        if (!is_numeric($value)) {
            return $default_value;
        }
        $value_float = $this->getParam($key, $source);
        $value_float = (float)str_replace(',', '.', $value_float);
        if (is_numeric($max_value) && $value_float > $max_value) {
            return $max_value;
        }

        return $value_float;
    }

    /**
     * @param $key
     * @param $source
     * @param $default_value
     * @param $min_value
     * @param $max_value
     *
     * @return mixed|string|null
     */
    protected function getParamString($key, $source = self::METHOD_GET, $default_value = null, $max_value = null, $min_value=null)
    {
        $value = $this->getParam($key, $default_value);

        if (!is_string($value)||strlen($value)<$min_value) {

            return $default_value;
        }

        $value_string = (string)$this->getParam($key, $default_value);

        if (is_numeric($max_value) && mb_strlen($value_string) > $max_value) {
            return $default_value;
        }

        return $value_string;
    }

    /**
     * @param string     $key
     * @param int        $source
     * @param mixed|null $default_value
     * @param null|int   $max_value максимальное значение
     *
     * @return int|null
     */
    protected function getParamInt($key, $source = self::METHOD_GET, $default_value = null, $max_value = 50)
    {
        $array_value = explode(',', $this->getParam($key, $default_value));
        $tired_value = [];

        if (is_numeric($max_value) && count($array_value) > $max_value) {
            return null;
        }

        foreach ($array_value as $value) {
            if (!is_numeric($value)) {
                return $default_value;
            }
            $tired_value[] = (int)$value;
        }

        return $tired_value;
    }

    /**
     * @param string     $key
     * @param mixed|null $default_value
     *
     * @return mixed|null
     */
    protected function getParam($key, $default_value = null)
    {
        $value = isset($_GET[$key]) ? $_GET[$key] : $default_value;
        if (!is_string($value) || $value === '') {
            return $default_value;
        }
        return $value;
    }
}