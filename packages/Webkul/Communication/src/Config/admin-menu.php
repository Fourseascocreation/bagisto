<?php

return [
    [
        'key' => 'communication',
        'name' => 'communication::app.communication',
        'route' => 'communication.newsletter-templates.index',
        'sort' => 7,
        'icon-class' => 'newsletter-icon',
    ],
    [
        'key' => 'communication.newsletter-templates',
        'name' => 'communication::app.newsletter-templates.newsletter-templates',
        'route' => 'communication.newsletter-templates.index',
        'sort' => 1,
        'icon-class' => '',
    ],
    [
        'key' => 'communication.newsletter-queue',
        'name' => 'communication::app.newsletter-queue.newsletter-queue',
        'route' => 'communication.newsletter-queue.index',
        'sort' => 1,
        'icon-class' => '',
    ],
];