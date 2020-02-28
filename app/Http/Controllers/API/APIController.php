<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class APIController extends Controller
{
    public $successStatus = 200;
    public  $failedStatus = 401;

    /**
     * login api
     *
     * error    code    msg
     * 101  email not exist
     * 102 password is not correct
     * 103 email not verified
     *
     */

    public static $emailNotExistCode = 101;
    public static $passwordInvalidCode = 102;
    public static $emailNotVerifiedCode = 103;

    public static $invalidParamsCode = 104;
    public static $emailExist = 105;


    public static $socialLoginFailed = 106;

    public static $invalidToken = 107;

    public static $emailVerifyCodeInvalid = 109;

    public static $invalidUserData = 111;

    public static $failedToPasswordRequest = 112;

    public static $resetTokenInvalid = 113;

    public static $notFound = 114;

    public static $invalidEmail = 115;

    public static $invalidPassword = 116;


    public function responseSuccess($data){
        return response()->json(['status' => true,  'data'=>$data], $this->successStatus);
    }

    public function responseFailed($error, $statusCode=401){
        return response()->json(['status' => false, 'error'=>$error], $statusCode);
    }

    public function responseFailedReg($errMsg,  $errCode, $statusCode=401){
        return response()->json(['status' => false, 'error'=>['code'=>$errCode, 'msg'=>$errMsg]], $statusCode);
    }

}
