<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Session Driver
    |--------------------------------------------------------------------------
    |
    | This option controls the default session "driver" that will be used on
    | requests. By default, we will use the lightweight native driver but
    | you may specify any of the other wonderful drivers provided here.
    |
    | Supported: "file", "cookie", "database", "apc",
    |            "memcached", "redis", "dynamodb", "array"
    |
    */

    'driver' => env('SESSION_DRIVER', 'file'),

    /*
    |--------------------------------------------------------------------------
    | Session Lifetime
    |--------------------------------------------------------------------------
    |
    | Here you may specify the number of minutes that will be allowed to
    | elapse before the user is required to re-authenticate. This includes
    | the time spent on inactive pages. If the user remains active, their
    | session will be extended for another lifetime duration.
    |
    */

    'lifetime' => env('SESSION_LIFETIME', 120),
    // Increased from 120 to 480 minutes (8 hours) for better user experience

    /*
    |--------------------------------------------------------------------------
    | Session Expire On Close
    |--------------------------------------------------------------------------
    |
    | Determines if the session will be marked as "expired on close" so that
    | it will automatically be destroyed when the browser is closed.
    |
    */

    'expire_on_close' => true,
    'lifetime' => env('SESSION_LIFETIME', 480),

    /*
    |--------------------------------------------------------------------------
    | Session Encryption
    |--------------------------------------------------------------------------
    |
    | This option allows you to easily specify that all of your session data
    | should be encrypted before it is stored. All encryption will be run
    | automatically by Laravel and you can use the data in your sessions
    | normally as if it was not encrypted.
    |
    */

    'encrypt' => false,

    /*
    |--------------------------------------------------------------------------
    | HTTP Access Only
    |--------------------------------------------------------------------------
    |
    | Setting this value to true will restrict access to the session cookie
    | only through the HTTP protocol. This will prevent access via JavaScript,
    | which helps protect against XSS attacks. Some applications may require
    | this to be set to false.
    |
    */

    'http_only' => true,

    /*
    |--------------------------------------------------------------------------
    | Same-Site Cookies
    |--------------------------------------------------------------------------
    |
    | This option determines how your cookies behave when cross-site requests
    | take place, and can be used to mitigate CSRF attacks. By default, we
    | will set this value to "lax" since this is a safer default value.
    |
    | Supported: "lax", "strict", "none", null
    |
    */

    'same_site' => 'lax',

    /*
    |--------------------------------------------------------------------------
    | Secure Cookies
    |--------------------------------------------------------------------------
    |
    | Setting this value to true will only attach session cookies to requests
    | over HTTPS, and all other cookies sent by the application will be sent
    | only to HTTPS requests. If you're developing locally over HTTP, change
    | this to false.
    |
    */

    'secure' => env('SESSION_SECURE_COOKIES', false),

    /*
    |--------------------------------------------------------------------------
    | Session Database Connection
    |--------------------------------------------------------------------------
    |
    | When using the "database" or "redis" session drivers, you may specify a
    | connection that should be used to manage these sessions. This should
    | correspond to a connection in your database configuration options.
    |
    */

    'connection' => env('SESSION_CONNECTION'),

    /*
    |--------------------------------------------------------------------------
    | Session Database Table
    |--------------------------------------------------------------------------
    |
    | When using the "database" session driver, you may specify the table we
    | should use to manage the sessions. Of course, a sensible default is
    | provided for you; however, you are free to change this as needed.
    |
    */

    'table' => 'sessions',

    /*
    |--------------------------------------------------------------------------
    | Session Cache Store
    |--------------------------------------------------------------------------
    |
    | When using the "apc", "memcached", "redis", or "dynamodb" session
    | drivers and you wish to store the session data in a cache store, you
    | may specify the cache store to utilize for that storage. Otherwise,
    | the default cache "store" will be used.
    |
    */

    'store' => env('SESSION_STORE'),

    /*
    |--------------------------------------------------------------------------
    | Session Sweeping Lottery
    |--------------------------------------------------------------------------
    |
    | Some session drivers must manually sweep their storage location to get
    | rid of old sessions from storage. Here are the chances that the garbage
    | collector will run on a given request. By default, the odds are 2 out
    | of 100.
    |
    */

    'lottery' => [2, 100],

    /*
    |--------------------------------------------------------------------------
    | Session Cookie Name
    |--------------------------------------------------------------------------
    |
    | Here you may change the name of the cookie used to identify a session
    | instance with the user. The name specified here will get used every
    | time a new session cookie is created by the framework for every
    | driver that manages sessions.
    |
    */

    'cookie' => env(
        'SESSION_COOKIE',
        strtolower(str_replace(' ', '_', env('APP_NAME', 'laravel'))) . '_session'
    ),

    /*
    |--------------------------------------------------------------------------
    | Session Cookie Path
    |--------------------------------------------------------------------------
    |
    | The session cookie path determines the path for which the cookie will
    | be regarded as available. Typically, this will be the root path of
    | your application but you are free to change this when necessary.
    |
    */

    'path' => '/',

    /*
    |--------------------------------------------------------------------------
    | Session Cookie Domain
    |--------------------------------------------------------------------------
    |
    | Here you may change the domain of the cookie used to identify a session
    | in your application. This will determine which domains the cookie is
    | available to in your application. A sensible default using the request
    | domain is provided.
    |
    */

    'domain' => env('SESSION_DOMAIN'),

    /*
    |--------------------------------------------------------------------------
    | Idle Timeout (in minutes)
    |--------------------------------------------------------------------------
    |
    | This value determines how long a user can remain inactive before being
    | automatically logged out. Set to 0 to disable idle timeout.
    |
    */

    'idle_timeout' => env('SESSION_IDLE_TIMEOUT', 120),

];
