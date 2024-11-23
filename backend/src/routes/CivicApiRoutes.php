<?php

class CivicApiRoutes
{
    public static function routes()
    {

        /**
         * Routes mapping for civic api actions
         */
        return [
            'GET' => [
                'events' => 'getEvents'
            ],
            'POST' => [
                'event' => 'postEvent'
            ]
        ];
    }
}