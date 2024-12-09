<?php

namespace Strucura\DataGrid\Traits;

trait HandlesMetaData
{
    /**
     * Miscellaneous metadata that can be used to store additional information about the data structure
     */
    protected array $meta = [];

    public function withMeta(string $key, mixed $value): static
    {
        $this->meta[$key] = $value;

        return $this;
    }

    public function getMeta(string $key): mixed
    {
        return $this->meta[$key] ?? null;
    }
}
