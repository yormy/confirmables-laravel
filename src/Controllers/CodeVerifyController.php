<?php

namespace Yormy\ConfirmablesLaravel\Controllers;

use Yormy\Apiresponse\Facades\ApiResponse;
use Yormy\ConfirmablesLaravel\DataObjects\VerificationError;
use Yormy\ConfirmablesLaravel\Models\Confirmable;
use Yormy\ConfirmablesLaravel\Requests\VerifyCodeRequest;
use Yormy\ConfirmablesLaravel\Services\CodeVerifier;

class CodeVerifyController
{
    public function verifyByEmail(VerifyCodeRequest $request)
    {
        $code = $request->validated('confirm_code');
        $xid = $request->validated('xid');
        $verifiedCode = CodeVerifier::verifyForEmail($code);

        $result = $this->isValid($verifiedCode, $xid);
        if ( $result !== true) {
            return $result;
        }

        $verifiedCode->confirmable->setEmailVerified();

        return $this->respond($verifiedCode->confirmable);
    }

    public function verifyByPhone(VerifyCodeRequest $request)
    {
        $code = $request->validated('confirm_code');
        $xid = $request->validated('xid');
        $verifiedCode = CodeVerifier::verifyForPhone($code);

        $result = $this->isValid($verifiedCode, $xid);
        if ( $result !== true) {
            return $result;
        }

        $verifiedCode->confirmable->setPhoneVerified();

        return $this->respond($verifiedCode->confirmable);
    }

    private function isValid($verifiedCode, string $xid)
    {
        if (!$verifiedCode || !$verifiedCode->confirmable) {
            return ApiResponse::errorResponse(VerificationError::INVALID_CODE);
        }

        if($verifiedCode->confirmable->xid !== $xid) {
            // The code did not match the action
            return ApiResponse::errorResponse(VerificationError::INVALID_CODE);
        }

        return true;
    }

    private function respond($confirmable)
    {
        $result = $confirmable->execute();

        if ($result === Confirmable::STATUS_EXECUTED) {
            $data = $confirmable->getSuccessResponse();

            return ApiResponse::withData($data)->successResponse();
        }

        $data = $confirmable->enterCodeResponse();

        return ApiResponse::withData($data)->successResponse();
    }

}
