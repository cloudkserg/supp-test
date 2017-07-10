<?php
use Swagger\Annotations as SWG;
/**
 * @SWG\Swagger(
 *     basePath="/",
 *     schemes={"http"},
 *     produces={"application/json"},
 *     consumes={"application/json"},
 *     @SWG\Info(
 *         version="1.0.0",
 *         title="Supp",
 *         description="An API that uses supp service",
 *     ),
 *     @SWG\Definition(
 *         definition="ErrorModel",
 *         required={"status_code", "message"},
 *         @SWG\Property(
 *             property="status_code",
 *             type="integer",
 *             format="int32"
 *         ),
 *         @SWG\Property(
 *             property="message",
 *             type="string"
 *         )
 *     ),
 *     @SWG\Response(
 *          response="NotAuthResponse",
 *          description="Not Auth",
 *          @SWG\Schema(ref="#/definitions/ErrorModel")
 *     ),
 *     @SWG\Response(
 *          response="NotFoundResponse",
 *          description="Not Found",
 *          @SWG\Schema(ref="#/definitions/ErrorModel")
 *     ),
 *     @SWG\Response(
 *          response="DefaultErrorResponse",
 *          description="Default Error",
 *          @SWG\Schema(ref="#/definitions/ErrorModel")
 *     ),
 * )
 */
/**
 * @SWG\SecurityScheme(
 *      securityDefinition="token",
 *      type="apiKey",
 *      in="query",
 *      name="token"
 *  )
 */
