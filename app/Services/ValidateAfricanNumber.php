<?php

namespace App\Services;

class ValidateAfricanNumber
{
    function isValid($number)
    {
        $pattern = "/^27[0-9]{9}$/";
        $isValid = preg_match($pattern, $number);
        if ($isValid) { 
            return $number;
        }
        return false;
    }

    function wrongPrefix($number)
    {
        $patternStart = "/^27/";
        $checkPrefix = preg_match($patternStart, $number);
        if (!$checkPrefix) {
            return true;
        }
        return false;
    }

    function checkLength($number)
    {
        if (strlen($number) == 9 && is_numeric($number)) {
            return true;
        }
        return false;
    }
    function isDeleted($number)
    {
        $patternLength = "/^27[0-9]{9}_DELETED_(.*)/";
        $deleted = preg_match($patternLength, $number);
        if ($deleted) {
            return true;
        }
        return false;
    }

    function validate($number)
    {
        $message = "";
        switch ($number) {
            case $this->isValid($number):
                return [
                    'number' => $number,
                    'message' => $message,
                    'state' => "correct",
                    'deleted_at' => null
                ];
            case $this->wrongPrefix($number):
                if ($this->checkLength($number)) {
                    $message = "Aggiunto prefisso";
                    $number =  "27" . $number;
                    return [
                        'number' => $number,
                        'message' => $message,
                        'state' => "modified",
                        'deleted_at' => null
                    ];
                }
                if (substr($number, 0, 9) == "_DELETED_") {
                    return [
                        'number' => null,
                        'message' => "Numero non presente",
                        'state' => "wrong",
                        'deleted_at' => null
                    ];
                }
                if (strpos($number, '_DELETED_')) {
                    $deletedArray = explode('_DELETED_', $number);
                    $data = $deletedArray[1] ?? $deletedArray[1];
                    $number = $deletedArray[0] ?? $deletedArray[0];
                    $message = 'Il prefisso è errato ed il numero risulta cancellato in data ' . date("Y-m-d H:i:s", $data);
                    return [
                        'number' => $number,
                        'message' => $message,
                        'state' => "wrong",
                        'deleted_at' => date("Y-m-d H:i:s", $data)
                    ];
                }
                $message = 'Il prefisso è errato ed il numero non può essere corretto dal sistema';
                return [
                    'number' => $number,
                    'message' => $message,
                    'state' => "wrong",
                    'deleted_at' => null
                ];
            case $this->isDeleted($number):
                $deletedArray = explode('_DELETED_', $number);
                $data = $deletedArray[1] ?? $deletedArray[1];
                $number = $deletedArray[0] ?? $deletedArray[0];
                $message = "Il numero è corretto ma risulta esser cancellato in data " . date("Y-m-d H:i:s", $data);

                return [
                    'number' => $number,
                    'message' => $message,
                    'state' => "modified",
                    'deleted_at' => date("Y-m-d H:i:s", $data)
                ];
            default:
                $message = "Non è stato possibile validare il numero. (lunghezza o formato non consentiti)";
                return [
                    'number' => $number,
                    'message' => $message,
                    'state' => "wrong",
                    'deleted_at' => null
                ];
        }
    }
}
