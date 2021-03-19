<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

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
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });

        //How to resolve the NotFounHTTPException error when updating or just selecting data
        
        $this->renderable(function(NotFoundHttpException $e, $request){
            //If the request waits for JSON formatted response 
            //(Accept:application/json and Content-Type:application/json), then we will send a JSON object
            //The browser will get a HTML page with 404 NOT FOUND info
            if($request->expectsJson()){
                return response()->json([
                    "data" => "Not found."
                ], 404);
            }           
        });
    }

}
