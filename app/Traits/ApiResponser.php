<?php

namespace App\Traits;

use Illuminate\Http\Response;
use Illuminate\Http\Request;


trait ApiResponser 
{
    /**
     * Sends a Successfull response with a given code
     *
     * @param $data
     * @param $code
     * @return \Illuminate\Http\JsonResponse
     */
    public function successResponse($data ,$code = Response::HTTP_OK)
    {
        return response()->json(['data' => $data, $code]);
    }

   /**
     * Sends an error code with a given code
     *
     * @param $message
     * @param $code
     * @return \Illuminate\Http\JsonResponse
     */
    protected function errorResponse($message, $code)
    {
        return response()->json(['error' => $message, 'code' => $code], $code);
    }
    /**
     * Sends a json with a collection of data with a 200 http code as default
     *
     * @param \Illuminate\Support\Collection $collection
     * @param int $code
     * @return \Illuminate\Http\JsonResponse
     */
    protected function showAll(Collection $collection, $code = 200)
    {
        return $this->successResponse(['data' => $collection], $code);
    }
    /**
     * sends a json response with only one result
     *
     * @param \Illuminate\Database\Eloquent\Model $instance
     * @param int $code
     * @return \Illuminate\Http\JsonResponse
     */
    protected function showOne(Model $instance, $code = 200)
    {
        return $this->successResponse(['data' => $instance], $code);
    }
}