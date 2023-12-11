<?php

namespace Larabookir\Gateway;

use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Larabookir\Gateway\Exceptions\PortNotFoundException;
use Larabookir\Gateway\Models\UserGateway;

class UserGatewayManagement
{
    static function assignGateway($request)
    {
        $gatewayRules = self::getRules();

        $gatewayId = $request->gateway_id;
        if (!in_array($gatewayId, config('gateway.gateway_ids'))) {
            throw new PortNotFoundException;
        }

        $validator = Validator::make($request->gateway_details, $gatewayRules[array_search($gatewayId, config('gateway.gateway_ids'))]);


        if ($validator->fails()) {
            $errors = $validator->errors()->all();
            return ValidationException::withMessages(['errors' => $errors]);
        }


        $userGateway = UserGateway::create([
            'user_id' => $request->user_id,
            'gateway_id' => $request->gateway_id,
            'gateway_details' => json_encode($request->gateway_details),
        ]);
        return $userGateway;
    }

    static function updateGateway($request)
    {
        $gatewayRules = self::getRules();

        $gatewayId = $request->gateway_id;
        if (!in_array($gatewayId, config('gateway.gateway_ids'))) {
            throw new PortNotFoundException;
        }

        $validator = Validator::make($request->gateway_details, $gatewayRules[array_search($gatewayId, config('gateway.gateway_ids'))]);


        if ($validator->fails()) {
            $errors = $validator->errors()->all();
            return ValidationException::withMessages(['errors' => $errors]);
        }

        $userGateway = UserGateway::query()->where('user_id', $request->user_id)->where('gateway_id', $request->gateway_id)->first();
        if (!$userGateway) {
            return ValidationException::withMessages(['index not found']);
        }
        $userGateway->update([
            'gateway_details' => json_encode($request->gateway_details),
        ]);

        return true;
    }

    static function detachGateway($request)
    {
        $userGateway = UserGateway::query()->where('user_id', $request->user_id)->where('gateway_id', $request->gateway_id)->first();
        if (!$userGateway) {
            return ValidationException::withMessages(['index not found']);
        }
        return $userGateway->delete();
    }

    static function getRules(){
        return [
            'zarinpal' => [
                'merchant_id' => 'required|regex:/^[0-9]{8}-[0-9]{4}-[0-9]{4}-[0-9]{4}-[0-9]{12}$/',
                'type' => 'required|in:zarin-gate,normal',
                'callback_url' => 'required|url',
                'server' => 'required|in:germany,iran,test',
                'email' => 'required|email',
                'mobile' => 'required|regex:/^09[0-9]{9}$/',
                'description' => 'required|string',
            ],
            'mellat' => [
                'username' => 'required',
                'password' => 'required',
                'terminalId' => 'required|numeric',
                'callback_url' => 'required|url',
            ],
            'saman' => [
                'merchant' => 'required',
                'password' => 'required',
                'callback_url' => 'required|url',
            ],
            'payir' => [
                'api' => 'required',
                'callback_url' => 'required|url',
            ],
            'irankish' => [
                'merchantId' => 'required',
                'sha1key' => 'required',
                'callback_url' => 'required|url',
            ],
            'sadad' => [
                'merchant' => 'required',
                'transactionKey' => 'required',
                'terminalId' => 'required|numeric',
                'callback_url' => 'required|url',
            ],
            'parsian' => [
                'pin' => 'required',
                'callback_url' => 'required|url',
            ],
            'pasargad' => [
                'terminalId' => 'required|numeric',
                'merchantId' => 'required|numeric',
                'certificate_path' => 'required|string', // You might want to add a custom rule for file existence if needed
                'callback_url' => 'required|url',
            ],
            'asanpardakht' => [
                'merchantId' => 'required',
                'merchantConfigId' => 'required',
                'username' => 'required',
                'password' => 'required',
                'key' => 'required',
                'iv' => 'required',
                'callback_url' => 'required|url',
            ],
            'paypal' => [
                'client_id' => 'required',
                'secret' => 'required',
                'settings.mode' => 'required|in:sandbox,live',
                'settings.http.ConnectionTimeOut' => 'required|numeric',
                'settings.log.LogEnabled' => 'required|boolean',
                'settings.log.FileName' => 'required|string',
                'settings.call_back_url' => 'required|string',
                'settings.log.LogLevel' => 'required|in:FINE,INFO,WARN,ERROR',
            ],
        ];
    }


}
