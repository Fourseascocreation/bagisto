<?php

namespace Webkul\Menu\Traits;

trait MakeAble
{
    /**
     * Make.
     *
     * @param  array|string  ...$arguments
     */
    public static function make(...$arguments): static
    {
        $static = new static(...$arguments);

        $static->afterMake();

        return $static;
    }

    /**
     * After make.
     */
    protected function afterMake(): void
    {
    }
}