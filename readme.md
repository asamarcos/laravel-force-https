# Laravel Force HTTPS

Workaround to deal with a particular environment that kills redirections from
port 80 (http) to 443 (https).

Once this package is enabled, the application should force all URLs to be https
while in 'production' environment.

# Install

Register the ServiceProvider in `config/app.php`

    'providers' => [

        // ...
        LSV\ForceHttps\ServiceProvider::class,
    ];
