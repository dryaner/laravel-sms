<?php

namespace LeadThread\Sms\Responses;

use LeadThread\Sms\Interfaces\SmsResponse;

class Plivo extends Response
{
    public function applyResponse($response)
    {
        if (isset($response['response'])) {
            if (isset($response['response']['error'])) {
                $this->error = $response['response']['error'];
            }
            if (isset($response['response']['message_uuid'])) {
                $this->uuid = $response['response']['message_uuid'][0];
            }
        }

        if (isset($response['available_phone_numbers'])) {
            $this->number = $response['available_phone_numbers'][0]['phone_number'];
            $this->numbers = collect($response['available_phone_numbers'])->pluck("phone_number")->all();
        }

        if (isset($response['status'])) {
            $this->status = $response["status"];
        }
    }

    public function successful()
    {
        return $this->status >= 200 && $this->status < 300;
    }
}
