<?php

namespace Webkul\Menu\Menu;

use Illuminate\Support\Collection;

class MenuGroup extends MenuElement
{
    /**
     * Create the new instance of the class
     *
     * @return void
     */
    public function __construct(
        public string $name,
        public string $route,
        public string $icon,
        public string $sort,
        public Collection|array $menuItems = [],
    ) {
    }
}
