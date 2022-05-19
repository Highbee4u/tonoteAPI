<?php
    include_once('constants.php');

    // Commented below line is for not get into trouble on production
    // error_reporting(1);

    function retResponse($code, $message, $status, $data=[]){
        http_response_code($code);
        echo json_encode(["status"=>$status, "msg"=>$message,"data"=>$data]);
        exit;
    }

    function checkContentType(){
        if(! isset($_SERVER['CONTENT_TYPE'])) $_SERVER['CONTENT_TYPE'] = '';

        $contentType = explode(';', $_SERVER['CONTENT_TYPE'])[0];

        // These are only content type which is valid in whole app
        // However You can change it accordingly
        $validContentType = [
            "application/json",
            "multipart/form-data",
            ''
        ];

        if(! in_array($contentType, $validContentType)) retResponse(406, 'Invalid Content Type', false);
    }

    function getJsonFromBody(){
        return json_decode(stream_get_contents(fopen('php://input', 'r')), true);
    }

    function getAuthHeader(){
        $headers = null;
        if (isset($_SERVER['Authorization'])) $headers = trim($_SERVER["Authorization"]);
        else if (isset($_SERVER['HTTP_AUTHORIZATION'])) $headers = trim($_SERVER["HTTP_AUTHORIZATION"]); //Nginx or fast CGI
        elseif (function_exists('apache_request_headers')) {
            $requestHeaders = apache_request_headers();
            // Server-side fix for bug in old Android versions (a nice side-effect of this fix means we don't care about capitalization for Authorization)
            $requestHeaders = array_combine(array_map('ucwords', array_keys($requestHeaders)), array_values($requestHeaders));
            if (isset($requestHeaders['Authorization'])) $headers = trim($requestHeaders['Authorization']);
        }
        return $headers;
    }

    function getBearerToken(){
        $headers = getAuthHeader();
        if(empty($headers)) retResponse(406, 'Headers Not Found', false);
        return explode(' ', $headers)[1];
    }

    function essentialCall($auth){
        checkContentType();
        if($auth) getBearerToken();
    }

    function validaterequiredfields($fields_array, $required_fields) 
    {
        $errors = array();
        foreach ($required_fields as $key)
        {
            if(empty($fields_array[$key])) {
                $errors[] = "{$key} is required";
            }else if(empty($fields_array[$key]) || !trim($fields_array[$key])){
                $errors[] = "{$key} can not be empty";
            }
        }
        return $errors;
    }

    function validatenumber($required_digit_fields, $data){
        $errors = array();
        foreach ($required_digit_fields as $key=>$val) {
            if(!empty($data[$val])){
                // $errors[] = "{$val} not empty";
                if (!preg_match ("/^\d*$/", $data[$val]) ) {  
                    $errors[] = "{$val} must be a numeric value and without any formatting";
                }
            }
        }
        return $errors;
    }

    function datechecker($posteddata){

        $curentdate = date('Y-m-d h:i:s', time());
        if(date_format($posteddata, 'Y-m-d h:i:s') < $curentdate){
            return false;
        }else{
            return true;
        }
    }

    function validateEmail($email) {
        $regex = "/^([a-zA-Z0-9\.]+@+[a-zA-Z]+(\.)+[a-zA-Z]{2,3})$/";
        return preg_match($regex, $email) ? true : false;
    }

    function validate_phone_number($phonenumber) {
        $pattern = '/^234[0-9]{10}/';
        return preg_match($pattern,$phonenumber) ? true : false;
    
    }

    function validate_date($date){
        if (preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/",$date)) {
            return true;
        } else {
            return false;
        }
    }
    

?>