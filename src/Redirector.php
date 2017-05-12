<?php

namespace LucasVscn\ForceHttps;

use Illuminate\Routing\Redirector as LaravelRedirector;

/**
 * @author  Lucas Vasconcelos <lucas@vscn.co>
 * @package LucasVscn\ForceHttps
 */
class Redirector extends LaravelRedirector
{
    /**
     * Create a new redirect response to the given path.
     *
     * @param  string  $path
     * @param  int     $status
     * @param  array   $headers
     * @param  bool    $secure
     * @return \Illuminate\Http\RedirectResponse
     */
    public function to($path, $status = 302, $headers = [], $secure = null)
    {
        // Always use https while not in local environment.
        if (! app()->isLocal()) {
            $secure = true;
        }

        $path = $this->generator->to($path, [], $secure);

        return $this->createRedirect($path, $status, $headers);
    }

    /**
     * Create a new redirect response to the previously intended location.
     *
     * @param  string  $default
     * @param  int     $status
     * @param  array   $headers
     * @param  bool    $secure
     * @return \Illuminate\Http\RedirectResponse
     */
    public function intended($default = '/', $status = 302, $headers = [], $secure = null)
    {
        $path = $this->session->pull('url.intended', $default);

        if (! app()->isLocal()) {
            $secure = true;
            $path = $default; // Fix pos login redirection
        }

        return $this->to($path, $status, $headers, $secure);
    }
}
