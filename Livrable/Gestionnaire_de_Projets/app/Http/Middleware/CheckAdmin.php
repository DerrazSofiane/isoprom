<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
class CheckAdmin
{
    /**
     * Traiter une demande entrante.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(!Auth::guest()){/*si authentifié*/
            if ($request->user()->Auth_hasRole('ADMIN')==true){/*si admin*/
             return $next($request);/*vous pouvez continuer votre prochaine requête*/
            }else{
            return response("Permission non accordée",401);/*il faut éviter cette réponse*/
            }
        }else{
            return response("Permission non accordée",401);
        }
    }
}
