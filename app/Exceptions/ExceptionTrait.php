<?php

namespace App\Exceptions;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

trait ExceptionTrait{

    public function apiException($request, $e){
        //if user entered a wrong id
        if ($e instanceof ModelNotFoundException){
            return response()->json(['errors' => 'Model Not Found'], Response::HTTP_NOT_FOUND);
        }

        //if user entered a wrong route
        if ($e instanceof NotFoundHttpException){
            return response()->json([
                'errors' => 'incorrect route'
            ],Response::HTTP_NOT_FOUND);
        }
        return parent::render($request, $e);



    }




}
