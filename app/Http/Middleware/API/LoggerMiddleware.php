<?php

namespace App\Http\Middleware\API;

use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class LoggerMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);
        $contents = json_decode($response->getContent(), true, 512);
        $headers  = $request->header();
        $dt = new Carbon();
        $data = [
            'path'         => $request->getPathInfo(),
            'method'       => $request->getMethod(),
            'ip'           => $request->ip(),
            'http_version' => $_SERVER['SERVER_PROTOCOL'],
            'timestamp'    => $dt->toDateTimeString(),
            'headers'      => [
                // get all the required headers to log
                'user-agent' => $headers['user-agent'] ?? 'default',
                'referer'    => $headers['referer'] ?? 'default',
                'origin'     => $headers['origin'] ?? 'default',
            ],
        ];

        // if request is authenticated
        if ($request->user()) {
            $data['user_id'] = $request->user()->id;
        }

        // if you want to log all the request body
        if (count($request->all()) > 0) {
            // keys to skip like password or any sensitive information
            $hiddenKeys = ['password'];

            $data['request'] = $request->except($hiddenKeys);
        }

        // get success response
        if (!empty($contents['success'] ?? '')) {
            $data['response']['success'] = $contents['success'];
        }

        // get errors
        if (!empty($contents['errors'])) {
            $data['response']['errors'] = $contents['errors'];
        }

        // get result
        if (!empty($contents['result'])) {
            $data['response']['result'] = $contents['result'];
        }

        // get message from the response
        if (!empty($contents['message'])) {
            $data['response']['message'] = $contents['message'];
        }

        // get api path
        $message = str_replace('/', '_', trim($request->getPathInfo(), '/'));

        Log::info($message, $data);
        return $response;
    }
}
