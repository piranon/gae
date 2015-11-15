<?php

// Codeigniter PHP class for Omise payment
// GAE -> STORECENTER -> PAYMENT
// @DEV.KONG
// Dev Ref: http://www.codeigniter.com/user_guide/general/creating_libraries.html

require_once (root_plugins_path() . "omise/config.php");


if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Omise {

    protected $CI;
    private $public_key;
    private $secret_key;

    // We'll use a constructor, as you can't directly call a function
    // from a property definition.
    public function __construct() {
        // Assign the CodeIgniter super-object
        $this->CI = & get_instance();

        // check if define global variable in config.php
        /*
        if (!OMISE_PUBLIC_KEY && !OMISE_SECRET_KEY) { // no variable define
            define('OMISE_PUBLIC_KEY', 'pkey_test_50p3ddbo39kypvbsoax');
            define('OMISE_SECRET_KEY', 'skey_test_50p2o28tscmb7m9f5l6');
        }
        */

        $this->public_key = OMISE_PUBLIC_KEY;
        $this->secret_key = OMISE_SECRET_KEY;
    }

    
    public function post_charge($dataArray) {
        // when someone want to pay something	
        $result = $this->charge_Create($dataArray);
        return $result;
    }

    public function get_charge_example(){
        // get result of charge id (string)
        $charge = OmiseCharge::retrieve("chrg_test_50s96mibem09cwhh15t");
        return (array) $charge;
    }
    
    public function get_charge($omis_payment_id){
        // get result of charge id (string)
        $charge = OmiseCharge::retrieve($omis_payment_id);
        return (array) $charge;
    }

    public function post_transfer($recipient, $amount) {
        return $this->tranfer_Create($recipient, $amount);
    }

    public function get_transaction($id) {
        try {
            $displayResult = OmiseTransaction::retrieve($id);
        } catch (OmiseException $e) {
            $displayResult = $e->getMessage();
        }
        return $displayResult;
    }

    /* Omise API function */

    private function charge_Create($dataArray) {
        if (isset($dataArray['omise_token'])) {
            // Charge a card.
            $data2send = array(
                'amount' => $this->moneySatang($dataArray['amount']),
                'currency' => 'thb',
                'card' => $dataArray['omise_token'],
                'return_uri' => $dataArray['return_uri'],
                'description' => $dataArray['description']
            );
            try {
                // send chart info to omise and store result
                $charge = OmiseCharge::create($data2send);

                // set default response to error
                $displayResult['ok'] = 0;
                $displayResult['msg'] = "";
                $displayResult['data'] = array();

                // check if parameter exist
                if ($charge['object'] === 'charge' && $charge['authorized'] && $charge['capture'] && $charge['captured']) {
                    // check if no error
                    if ($charge['failure_code'] === NULL || $charge['failure_code'] === "null" || $charge['failure_code'] === "") {
                        // check if transaction success
                        if ($charge['authorized'] === true && $charge['captured'] === true) {
                            $displayResult['ok'] = 1;
                            $displayResult['msg'] = "payment complete";
                            $displayResult['data'] = (array) $charge;
                        } else {
                            // error
                            $displayResult['msg'] = 'card unauthorize';
                            $displayResult['data'] = (array) $charge;
                        }
                    } else {
                        // error
                        $displayResult['msg'] = "card error: (" . (array) $charge['failure_code'] . ') ' . (array) $charge['failure_message'];
                    }
                }
            } catch (OmiseException $e) {
                $displayResult['msg'] = $e->getMessage();
            }
            return $displayResult;
        } else {
            return array('ok' => 0, 'msg' => 'no token');
        }
    }

    private function tranfer_Create($recipient, $amount) {
        // set default response to error
        $displayResult['ok'] = 0;
        $displayResult['msg'] = "";
        $displayResult['data'] = array();

        $params = array(
            'amount' => $this->moneySatang($amount),
            'recipient' => $recipient //'recp_test_50pvsmtkxw47glwq70v'
        );

        try {
            $transfer = OmiseTransfer::create($params, $this->public_key, $this->secret_key);

            $displayResult['ok'] = 1;
            $displayResult['msg'] = "success";
            $displayResult['data'] = (array) $transfer;
        } catch (OmiseException $e) {
            $displayResult['msg'] = $e->getMessage();
        }

        return $displayResult;
    }

    /* Helpers function */

    public function moneySatang($value) {
        $a = str_replace(",", "", $value);
        return intval($a . '00');
    }

}
