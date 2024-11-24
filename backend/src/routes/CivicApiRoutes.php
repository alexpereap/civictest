<?php

class CivicApiRoutes
{
    public static function routes()
    {

        /**
         * Routes mapping for url endpoints and controllers
         * GET: /events/{id} = calls getEvents controller
         * POST: /event = calls postEvent controller
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