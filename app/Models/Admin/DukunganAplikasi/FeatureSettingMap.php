<?php

namespace App\Models\Admin\DukunganAplikasi;

use ArrayAccess;

class FeatureSettingMap implements ArrayAccess
{
    protected array $features = [];

    public function __construct(array $features = [])
    {
        $this->features = $features;
    }

    public function __get(string $name)
    {
        if (array_key_exists($name, $this->features)) {
            return (bool) $this->features[$name];
        }
        return true;
    }

    public function __isset(string $name): bool
    {
        return array_key_exists($name, $this->features);
    }

    public function isActive(string $code, bool $default = true): bool
    {
        if (array_key_exists($code, $this->features)) {
            return (bool) $this->features[$code];
        }
        return $default;
    }

    public function offsetExists($offset): bool
    {
        return array_key_exists($offset, $this->features);
    }

    public function offsetGet($offset): mixed
    {
        return $this->isActive((string) $offset);
    }

    public function offsetSet($offset, $value): void
    {
        $this->features[$offset] = $value;
    }

    public function offsetUnset($offset): void
    {
        unset($this->features[$offset]);
    }

    public function toArray(): array
    {
        return $this->features;
    }
}
