<?php

namespace fXmlRpc\Serialization\Value;

/**
 * Value object representing Base64-encoded and raw string value
 *
 * @author Lars Strojny <lstrojny@php.net>
 */
final class Base64Value implements Base64
{
    /**
     * @var string
     */
    private $encoded;

    /**
     * @var string
     */
    private $decoded;

    /**
     * @param string $encoded
     * @param string $decoded
     */
    private function __construct($encoded, $decoded)
    {
        $this->encoded = $encoded;
        $this->decoded = $decoded;
    }

    /**
     * Returns new base64 value object by encoded value
     *
     * @param string $string
     *
     * @return self
     */
    public static function serialize($string)
    {
        return new static(null, $string);
    }

    /**
     * Returns new base64 value by string
     *
     * @param string $value
     *
     * @return self
     */
    public static function deserialize($value)
    {
        return new static(trim($value), null);
    }

    /**
     * {@inheritdoc}
     */
    public function getEncoded()
    {
        if (!isset($this->encoded)) {
            $this->encoded = base64_encode($this->decoded);
        }

        return $this->encoded;
    }

    /**
     * {@inheritdoc}
     */
    public function getDecoded()
    {
        if (!isset($this->decoded)) {
            $this->decoded = base64_decode($this->encoded);
        }

        return $this->decoded;
    }
}
