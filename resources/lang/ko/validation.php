<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */


    'accepted' => ':attribute를 수락해야 합니다.',
    'active_url' => ':attribute은(는) 유효한 URL이 아닙니다.',
    'after' => ':attribute는 :date 이후의 날짜여야 합니다.',
    'after_or_equal' => ':attribute는 날짜가 :date 이후이거나 같아야 합니다.',
    'alpha' => ':attribute에는 문자만 포함되어야 합니다.',
    'alpha_dash' => ':attribute에는 문자, 숫자, 대시 및 밑줄만 포함되어야 합니다.',
    'alpha_num' => ':attribute에는 문자와 숫자만 포함되어야 합니다.',
    'array' => ':attribute는(는) 배열이어야 합니다.',
    'before' => ':attribute는 :date 이전의 날짜여야 합니다.',
    'before_or_equal' => ':attribute는:date 이전의 날짜이거나 같아야 합니다.',
    'between' => [
        'numeric' => ':attribute는 :min과 :max 사이에 있어야 합니다.',
        'file' => ':attribute은(는) :min과 :max 킬로바이트 사이여야 합니다.',
        'string' => ':attribute은(는) :min과 :max 문자 사이여야 합니다.',
        'array' => ':attribute에는 :min과 :max 항목 사이에 있어야 합니다.',
    ],
    'boolean' => ':attribute 필드는 true 또는 false여야 합니다.',
    'confirmed' => ':attribute 확인이 일치하지 않습니다.',
    'current_password' => '비밀번호가 틀립니다.',
    'date' => ':attribute는 유효한 날짜가 아닙니다.',
    'date_equals' => ':attribute는 날짜가 :date와 같아야 합니다.',
    'date_format' => ':attribute가 형식:format과 일치하지 않습니다.',
    'different' => ':attribute와 :other는 달라야 합니다.',
    'digits' => ':attribute은(는) :digits 숫자여야 합니다.',
    'digits_between' => ':attribute은(는) :min과 :max 숫자 사이여야 합니다.',
    'dimensions' => ':attribute에 잘못된 이미지 크기가 있습니다.',
    'distinct' => ':attribute 필드에 중복 값이 ​​있습니다.',
    'email' => ':attribute는 유효한 이메일 주소여야 합니다.',
    'ends_with' => ':attribute는 다음 중 하나로 끝나야 합니다: :values.',
    'exists' => '선택한 :attribute가 잘못되었습니다.',
    'file' => ':attribute는(는) 파일이어야 합니다.',
    'filled' => ':attribute 필드에는 값이 있어야 합니다.',
    'gt' => [
        'numeric' => ':attribute는 :value보다 커야 합니다.',
        'file' => ':attribute는 :value KB보다 커야 합니다.',
        'string' => ':attribute는 :value 문자보다 커야 합니다.',
        'array' => ':attribute에는 :value 이상의 항목이 있어야 합니다.',
    ],
    'gte' => [
        'numeric' => ':attribute는 :value보다 크거나 같아야 합니다.',
        'file' => ':attribute는 :value KB보다 크거나 같아야 합니다.',
        'string' => ':attribute는 :value 문자보다 크거나 같아야 합니다.',
        'array' => ':attribute에는 :value 항목 이상이 있어야 합니다.',
    ],
    'image' => ':attribute는(는) 이미지여야 합니다.',
    'in' => '선택한 :attribute가 잘못되었습니다.',
    'in_array' => ':attribute 필드가 :other에 존재하지 않습니다.',
    'integer' => ':attribute는 정수여야 합니다.',
    'ip' => ':attribute은(는) 유효한 IP 주소여야 합니다.',
    'ipv4' => ':attribute는(는) 유효한 IPv4 주소여야 합니다.',
    'ipv6' => ':attribute는(는) 유효한 IPv6 주소여야 합니다.',
    'json' => ':attribute는 유효한 JSON 문자열이어야 합니다.',
    'lt' => [
        'numeric' => ':attribute는:value보다 작아야 합니다.',
        'file' => ':attribute는:value 킬로바이트보다 작아야 합니다.',
        'string' => ':attribute는:value 문자보다 작아야 합니다.',
        'array' => ':attribute에는 :value보다 작은 항목이 있어야 합니다.',
    ],
    'lte' => [
        'numeric' => ':attribute는:value보다 작거나 같아야 합니다.',
        'file' => ':attribute는:value 킬로바이트보다 작거나 같아야 합니다.',
        'string' => ':attribute는 :value 문자보다 작거나 같아야 합니다.',
        'array' => ':attribute에는 :value 항목을 초과할 수 없습니다.',
    ],
    'max' => [
        'numeric' => ':attribute는:max보다 클 수 없습니다.',
        'file' => ':attribute은(는) :max 킬로바이트보다 커서는 안 됩니다.',
        'string' => ':attribute는 :max 문자보다 커서는 안 됩니다.',
        'array' => ':attribute에는 :max 항목을 초과할 수 없습니다.',
    ],
    'mimes' => ':attribute은(는) 다음 유형의 파일이어야 합니다.',
    'mimetypes' => ':attribute은(는) 다음 유형의 파일이어야 합니다.:values.',
    'min' => [
        'numeric' => ':attribute는 최소 :min이어야 합니다.',
        'file' => ':attribute는 최소 :min 킬로바이트 이상이어야 합니다.',
        'string' => ':attribute는 최소한 :min 문자여야 합니다.',
        'array' => ':attribute에는 최소한 :min 항목이 있어야 합니다.',
    ],
    'multiple_of' => ':attribute는:value의 배수여야 합니다.',
    'not_in' => '선택한 :속성이 잘못되었습니다.',
    'not_regex' => ':attribute 형식이 잘못되었습니다.',
    'numeric' => ':attribute는(는) 숫자여야 합니다.',
    'password' => '비밀번호가 틀립니다.',
    'present' => ':attribute 필드가 있어야 합니다.',
    'regex' => ':attribute 형식이 잘못되었습니다.',
    'required' => ':attribute 필드는 필수입니다.',
    'required_if' => ':other가 :value일 때 :attribute 필드가 필요합니다.',
    'required_unless' => ':other가 :values에 있지 않으면 :attribute 필드는 필수입니다.',
    'required_with' => ':values가 있는 경우 :attribute 필드가 필요합니다.',
    'required_with_all' => ':values가 있는 경우 :attribute 필드가 필요합니다.',
    'required_without' => ':values가 없으면 :attribute 필드가 필요합니다.',
    'required_without_all' => ':values가 없을 때 :attribute 필드가 필요합니다.',
    'prohibited' => ':attribute 필드는 금지되어 있습니다.',
    'prohibited_if' => ':other가 :value일 때 :attribute 필드는 금지됩니다.',
    'prohibited_unless' => ':other가 :values에 있지 않으면 :attribute 필드가 금지됩니다.',
    'same' => ':attribute 및 :other가 일치해야 합니다.',
    'size' => [
        'numeric' => ':attribute는:크기여야 합니다.',
        'file' => ':attribute은(는) :size 킬로바이트여야 합니다.',
        'string' => ':attribute은(는) :size 문자여야 합니다.',
        'array' => ':attribute에는 :size 항목이 포함되어야 합니다.',
    ],
    'starts_with' => ':attribute는 다음 중 하나로 시작해야 합니다. :values.',
    'string' => ':attribute는 문자열이어야 합니다.',
    'timezone' => ':attribute은(는) 유효한 시간대여야 합니다.',
    'unique' => ':attribute가 이미 사용되었습니다.',
    'uploaded' => ':attribute를(를) 업로드하지 못했습니다.',
    'url' => ':attribute는 유효한 URL이어야 합니다.',
    'uuid' => ':attribute는 유효한 UUID여야 합니다.',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap our attribute placeholder
    | with something more reader friendly such as "E-Mail Address" instead
    | of "email". This simply helps us make our message more expressive.
    |
    */

    'attributes' => [],

];
