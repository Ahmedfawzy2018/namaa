<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;
trait ApiResponseTrait
{
    protected $statusCode = 200;

    /**
     * This Function for getting the status code
     * @return int $this->statusCode
     */
    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    /**
     * This Function for setting the status code
     * @param int $statusCode
     * @return Object $this
     */
    public function setStatusCode(int $statusCode)
    {
        $this->statusCode = $statusCode;

        return $this;
    }

    /**
     * This Function for setting the status code to 404
     * @return JsonResponse
     */
    public function respondNotFound(): JsonResponse
    {
        return $this->setStatusCode(404)->respond([]);
    }

    /**
     * This Function for setting the status code to 401
     * @return JsonResponse
     */
    public function respondBadRequest($message=null): JsonResponse
    {
        return $this->setStatusCode(400)->respond(!$message?[]:['message'=>$message]);
    }

    /**
     * This Function for setting the status code to 401
     * @return JsonResponse
     */
    public function respondUnAuthorized($message=null): JsonResponse
    {
        return $this->setStatusCode(401)->respond(!$message?[]:['message'=>$message]);
    }

    /**
     * This Function for setting the status code to 500
     * @return JsonResponse
     */
    public function respondInternalError($message=null): JsonResponse
    {
        return $this->setStatusCode(500)->respond(!$message?[]:['message'=>$message]);
    }

    /**
     * This Function for getting a JSON encoded response
     * "?" means nullable
     * @param  nullable array $data
     * @param  nullable array $headers
     * @return \Illuminate\Http\JsonResponse
     */
    public function respond($data=[], ?array $headers = []): JsonResponse
    {
        return Response()->json(['data' => $data], $this->getStatusCode(), $headers);
    }


    /**
     * This Function for setting the status code to 201
     * @return JsonResponse
     */
    public function respondCreated(): JsonResponse
    {
        return $this->setStatusCode(200)->respond([]);
    }


    /**
     * This Function for setting the status code to 201
     * @return JsonResponse
     */
    public function respondDeleted($msg=null): JsonResponse
    {
        return $this->setStatusCode(200)->respond($msg ?? 'success');
    }


}
