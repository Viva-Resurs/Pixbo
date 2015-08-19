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
    'error_input'          => 'Det är något fel med indata.',
    'accepted'             => ':attribute måste accepteras.',
    'active_url'           => ':attribute är ej en giltig URL.',
    'after'                => ':attribute måste vara ett datum efter :date.',
    'alpha'                => ':attribute måste endast bestå av bokstäver.',
    'alpha_dash'           => ':attribute måste endast bestå av siffror, bokstäver och sträck.',
    'alpha_num'            => ':attribute måste endast bestå av siffror och bokstäver.',
    'array'                => ':attribute måste vara en lista.',
    'before'               => ':attribute måste vara ett datum före :date.',
    'between'              => [
        'numeric' => ':attribute måste vara mellan :min och :max.',
        'file'    => ':attribute måste vara mellan :min och :max kilobytes.',
        'string'  => ':attribute måste vara mellan :min och :max bokstäver.',
        'array'   => ':attribute måste vara mellan :min och :max objekt.',
    ],
    'boolean'              => ':attribute fältet måste vara sant eller falskt.',
    'confirmed'            => ':attribute matchar ej.',
    'date'                 => ':attribute är ej ett giltigt datum.',
    'date_format'          => ':attribute matchar inte formatet :format.',
    'different'            => ':attribute måste :other måste vara olika.',
    'digits'               => ':attribute måste vara :digits siffror.',
    'digits_between'       => ':attribute måste vara mellan :min och :max siffror.',
    'email'                => ':attribute måste vara en giltig email adress.',
    'filled'               => ':attribute fältet krävs.',
    'exists'               => 'Det valda :attribute är ogiltigt.',
    'image'                => ':attribute måste vara en bild.',
    'in'                   => 'Det valda :attribute är ogiltigt.',
    'integer'              => ':attribute måste vara ett nummer.',
    'ip'                   => ':attribute måste vara en giltig IP adress.',
    'max'                  => [
        'numeric' => ':attribute får ej överstiga :max siffror.',
        'file'    => ':attribute får ej överstiga :max kilobytes.',
        'string'  => ':attribute får ej vara längre än :max tecken.',
        'array'   => ':attribute får ej ha fler än :max objekt.',
    ],
    'mimes'                => ':attribute måste vara av filtypen :values.',
    'min'                  => [
        'numeric' => ':attribute måste vara minst :min siffror.',
        'file'    => ':attribute måste vara minst :min kilobytes.',
        'string'  => ':attribute måste vara minst :min tecken.',
        'array'   => ':attribute måste ha minst :min objekt.',
    ],
    'not_in'               => 'Det valda :attribute är ogiltigt.',
    'numeric'              => ':attribute måste vara ett nummer.',
    'regex'                => ':attribute formatet är ogiltigt.',
    'required'             => ':attribute fältet krävs.',
    'required_if'          => ':attribute fältet krävs när :other är :value.',
    'required_with'        => ':attribute fältet krävs när :values finns.',
    'required_with_all'    => ':attribute fältet krävs när :values finns.',
    'required_without'     => ':attribute fältet krävs när :values ej finns.',
    'required_without_all' => ':attribute krävs när inget av :values finns.',
    'same'                 => ':attribute och :other måste matcha.',
    'size'                 => [
        'numeric' => ':attribute måste vara :size.',
        'file'    => ':attribute måste vara :size kilobytes.',
        'string'  => ':attribute måste vara :size tecken.',
        'array'   => ':attribute måste innehålla :size objekt.',
    ],
    'string'               => ':attribute måste vara en sträng.',
    'timezone'             => ':attribute måste vara en giltig tidszone.',
    'unique'               => ':attribute finns redan och måste vara unik.',
    'url'                  => ':attribute formatet är ogiltigt.',

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

    'custom'               => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap attribute place-holders
    | with something more reader friendly such as E-Mail Address instead
    | of "email". This simply helps us make messages a little cleaner.
    |
     */

    'attributes'           => [],

];
