<?php


namespace app\helpers;

/**
 * class ApiConstant
 *
 * @author  Binh Nguyen <binhnt@dtsmart.vn>
 * @package app\common\helper\response
 * Date: 10/21/2022
 * Time: 11:21 PM
 * @version 1.0.0
 */
class ApiConstant
{
    /**
     * CONST:
     * SC: STATUS CODE
     * 200: Status OK
     * 204: No Content
     * 400: Bad Request(Missing Params,..)
     * 401: Unauthorized
     * 405: INVALID METHOD
     * 500: General error response, return if catch exception.
     */
    const SC_OK = 200;
    const SC_NO_RESULT = 204;
    const SC_BAD_REQUEST = 400;
    const SC_UNAUTHORIZED = 401;
    const SC_INVALID_METHOD = 405;
    const SC_EXCEPTION = 500;
    const SR_NOT_FOUND = 404;

    const STATUS_FAIL = 'FAIL';
    const STATUS_OK = 'OK';

    const STATUS_INVALID_METHOD = "INVALID_METHOD";
    const STATUS_MISSING_PARAMS = "MISSING_PARAMS";
    const STATUS_RESULT_NOT_FOUND = "RESULT_NOT_FOUND";
    const STATUS_INVALID_DATA = "INVALID_DATA";
    const STATUS_INTERNAL_SERVER_ERROR = "INTERNAL_SERVER_ERROR";
}