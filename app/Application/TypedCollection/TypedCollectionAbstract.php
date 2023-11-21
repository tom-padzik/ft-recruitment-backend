<?php

declare(strict_types=1);

namespace App\Application\TypedCollection;

use App\Application\TypedCollection\Exceptions\TypedCollectionInvalidArgumentException;
use Illuminate\Support\Collection;

use function is_object;

abstract class TypedCollectionAbstract extends Collection
{
    abstract protected function validateType(mixed $item): bool;

    public function __construct($items = [])
    {
        $this->checkTypes(...$items);
        parent::__construct($items);
    }

    public function add($item): self
    {
        $this->checkType(item: $item);
        return parent::add($item);
    }

    public function pluck($value, $key = null): Collection
    {
        return $this->toLaraCollection()
            ->pluck($value, $key);
    }

    public function keys()
    {
        return $this->toLaraCollection()->keys();
    }

    public function toLaraCollection(): Collection
    {
        return Collection::make($this->items);
    }

    public function toArray(): array
    {
        return $this->toLaraCollection()->toArray();
    }

    public function map(callable $callback)
    {
        return $this->toLaraCollection()
            ->map($callback);
    }

    public function push(...$items): self
    {
        foreach ($items as $item) {
            $this->checkType($item);
        }
        return parent::push(...$items);
    }

    public function offsetSet($key, $value): void
    {
        $this->checkType(item: $value);
        parent::offsetSet($key, $value);
    }

    public function prepend($value, $key = null): self
    {
        $this->checkType(item: $value);
        return parent::prepend($value, $key);
    }

    protected function checkTypes(...$items): void
    {
        foreach ($items as $item) {
            $this->checkType(item: $item);
        }
    }

    protected function checkType($item): void
    {
        if (true === $this->validateType(item: $item)) {
            return;
        }

        throw new TypedCollectionInvalidArgumentException(item: $item);
    }
}
