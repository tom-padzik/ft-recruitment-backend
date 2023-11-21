<?php

declare(strict_types=1);

namespace App\Application\TypedCollection\Exceptions;

use InvalidArgumentException;

class TypedCollectionInvalidArgumentException extends InvalidArgumentException
{
    public function __construct($item)
    {
        parent::__construct(
            sprintf(
                'Collection does not allow elements type %s',
                $this->getItemType($item)
            )
        );
    }

    private function getItemType($item): string
    {
        $type = is_object($item) ? get_class($item) : gettype($item);

        return $type ?? 'NULL';
    }
}
