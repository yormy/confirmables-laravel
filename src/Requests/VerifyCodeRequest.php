<?php declare(strict_types=1);

namespace Yormy\ConfirmablesLaravel\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VerifyCodeRequest extends FormRequest
{
    /**
     * @return array
     */
    public function rules(): array
    {
        $rules['confirm_code'] = ['required', 'min:3', 'max:10'];
        $rules['xid'] = ['required'];

        return $rules;
    }
}
