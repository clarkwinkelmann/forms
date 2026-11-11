<?php

return [

    // addresses of the reverse proxies whose X-Forwarded-* headers we trust, separated by commas
    // "*" trusts whichever address connects to us, so the app must not be reachable without the proxy
    'proxies' => env('TRUSTED_PROXIES'),

];
