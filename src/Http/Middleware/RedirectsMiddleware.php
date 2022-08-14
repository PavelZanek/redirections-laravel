<?php

namespace PavelZanek\RedirectionsLaravel\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use PavelZanek\RedirectionsLaravel\Models\Redirect;

class RedirectsMiddleware
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
        $oldUrls = Cache::rememberForever('redirects_cache', function () {
            return Redirect::select('source_url')->get();
        });

        $redirectFromCache = $oldUrls->where('source_url', $request->url())->first();
        if($redirectFromCache){
            $redirectFromDb = Redirect::where('source_url', $redirectFromCache->source_url)->first();
            $redirectFromDb->update([
                'last_used' => now()
            ]);
            return redirect(
                $redirectFromDb->target_url,
                301// $redirectFromDb->is_permanent ? 301 : 302
            );
        }

        return $next($request);
    }
}
