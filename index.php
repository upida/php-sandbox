<?php

require './vendor/autoload.php';

function randomFunc(int $num = 0) {
    echo "Number : from randomFunc";
}

function randomFuncWithReturn(int $num = 0) {
    return "Number : $num from randomFuncWithReturn";
}

function checkConditionCustomCode($code) {
    $sandbox = new PHPSandbox\PHPSandbox;
    $setting = [
        "code" => "",
        "setup_code" => "",
        "prepend_code" => "",
        "append_code" => "",
        "options" => [
            "error_level" => "32767"
        ],
        "whitelist" => [
            "func" => [
                "json_encode",
                "json_decode",
                "trim",
                "rand",
                "switch",
                "str_replace",
                "str_ireplace",
                "preg_match",
                "preg_replace",
                "count",
                "sizeof",
                "strtolower",
                "strtoupper",
                "strstr",
                "substr",
                "intval",
                "floatval",
                "date",
                "strtotime",
                "strlen",
                "md5",
                "mktime",
                "time",
                "strpos",
                "number_format",
                "explode",
                "implode",
                "similar_text",
                "isset",
                "unset",
                "is_array",
                "in_array",
                "ucfirst",
                "ucwords",
                "is_numeric",
                "shuffle",
                "array_rand",
                "array_slice",
                "json_last_error",
                "stripslashes",
                "strip_tags",
                "filter_var",
                "print_r",
                "floor",
                "ceil",
                "serialize",
                "unserialize",
                "urlencode",
                "strcasecmp",
                "date_diff",
                "date_create",
                "openssl_decrypt",
                "openssl_encrypt",
                "base64_encode",
                "base64_decode",
                "chr",
                "str_split",
                "array_search",
                "array_keys",
                "addslashes"
            ],
            "var" => [],
            "global" => [],
            "superglobal" => [],
            "const" => [
                "PHP_EOL",
                "FILTER_VALIDATE_BOOLEAN",
                "FILTER_VALIDATE_EMAIL",
                "FILTER_VALIDATE_FLOAT",
                "FILTER_VALIDATE_INT",
                "FILTER_VALIDATE_IP",
                "FILTER_VALIDATE_MAC",
                "FILTER_VALIDATE_REGEXP",
                "FILTER_VALIDATE_URL",
                "OPENSSL_RAW_DATA"
            ],
            "magic_const" => [],
            "namespace" => [],
            "alias" => [],
            "class" => [],
            "interface" => [],
            "trait" => [],
            "keyword" => [],
            "operator" => [],
            "primitive" => [],
            "type" => []
        ],
        "blacklist" => [
            "func" => [
                "foreach"
            ],
            "var" => [],
            "global" => [],
            "superglobal" => [],
            "const" => [],
            "magic_const" => [],
            "namespace" => [],
            "alias" => [],
            "class" => [],
            "interface" => [],
            "trait" => [],
            "keyword" => [
                "while",
                "repeat"
            ],
            "operator" => [],
            "primitive" => [],
            "type" => []
        ],
        "definitions" => [
            "func" => [],
            "var" => [],
            "superglobal" => [],
            "const" => [],
            "magic_const" => [],
            "namespace" => [],
            "alias" => [],
            "class" => [],
            "interface" => [],
            "trait" => []
        ]
    ];

    $sandbox->import(array(
        'setup_code' => $setting['setup_code'],
        'prepend_code' => $setting['prepend_code'],
        'append_code' => $setting['append_code'],
        'options' => $setting['options'],
        'whitelist' => $setting['whitelist'],
        'blacklist' => $setting['blacklist'],
        'definitions' => $setting['definitions']
    ));

    $sandbox->setErrorHandler(function($errno, $errmsg, $errfile, $errline) { 
        echo json_encode(['result' => 'error', 'message' => 'Error: '.$errmsg.' on line '.$errline]);
        exit;
    });
    
    $sandbox->setExceptionHandler(function(\Exception $e) { 
        echo json_encode(['result' => 'error', 'message' => 'Exception: '.$e->getMessage().' on line '.$e->getLine()]);
        exit;
    });

    $sandbox->setValidationErrorHandler(function(\PHPSandbox\Error $e) { 
        echo json_encode(['result' => 'error', 'message' => 'Exception: '.$e->getMessage()]);
        exit;
    });

    // randomFunc()
    $sandbox->defineFunc("randomFunc", function(int $param = 0) {
        return randomFunc($param);
    });

    // randomFuncWithReturn()
    $sandbox->defineFunc("randomFuncWithReturn", function(int $param = 0) {
        return randomFuncWithReturn($param);
    });

    try {
        $sandbox->prepare($code);
        $sandbox->execute();
    } catch(Throwable|Exception $e) {
        return ['result' => 'error', 'message' => 'Throwable|Exception: '.$e->getMessage()];
    }

}

$var = null;

$code = '
$var = curl_init(1);
';

echo $var;

echo json_encode(checkConditionCustomCode($code));