<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {
    /*   if ($e instanceof HttpException) {
         $e = new HttpException(503, $e->getMessage());
         return $this->renderHttpException($e);
       }
      // page 404 lorsqu'un modèle est introuvable
    if ($e instanceof ModelNotFoundException) {
      $e = new ModelNotFoundException(404, $e->getMessage());
      return $this->renderModelNotFoundException($e);
        //return response()->abort(404, 'Page introuvable !');
    }
    // message d'erreur personnalisé
    if ($e instanceof \ErrorException) {
      $e = new ErrorException(500, $e->getMessage());
      return $this->renderErrorException($e);
      //  return response()->abort(500,'Oups quelque chose s'est mal passé !');
    } else {
        return parent::render($request, $e);
    }*/
        return parent::render($request, $exception);
    }
    /**
     * Convertir une exception d'authentification en une réponse non authentifiée.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Illuminate\Auth\AuthenticationException  $exception
     * @return \Illuminate\Http\Response
     */
    protected function unauthenticated($request, AuthenticationException $exception)
    {
        if ($request->expectsJson()) {
            return response()->json(['error' => 'Non authentifié.'], 401);
        }

        return redirect()->guest(route('login'));
    }
    /*
    *générer une erreur en raison d'une valeur manquante
    */
    /*protected function missingvalue($request,UnexpectedValueException $exception)
    {

        return 'Oups quelque chose s&#39;est mal passé!';
    });
    /*
    *erreur d'exception de routage ResourceNotFoundException
    *
    protected function routingException($request,NotFoundHttpException $exception)
    {
      abort(500, 'Oups la page que vous recherchez est manquante');
    });*/
}
