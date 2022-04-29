<?php

namespace App\Http\Controllers;

use App\Models\PhoneNumber;
use Exception;
use Illuminate\Http\Request;

class PhoneNumberController extends Controller
{
    public function index()
    {
        return view('african_numbers.index');
    }

    public function show($filter = null)
    {
        $phoneNumber = PhoneNumber::all();
        if ($filter) {
            $phoneNumber = PhoneNumber::where('state', 'correct')->orWhere('state','modified')->get();
        }
        return view('african_numbers.show', ['numbers' => $phoneNumber]);
    }
    public function store(Request $request)
    {
        $request->validate([
            'africanNumbers' => 'required|mimes:csv,txt',
        ]);

        $arrayNumbers = [];
        $path = $request->file('africanNumbers')->getRealPath();

        try {
            $file = fopen($path, "r");
            while (($row = fgetcsv($file)) !== false) {
                $arrayNumbers[] = $row;
            }
            fclose($file);
        } catch (Exception $e) {
            return "Si è verificato un errore " . $e->getMessage();
        }
        if (count($arrayNumbers) > 0) { //
            foreach ($arrayNumbers as $key => $row) {
                if ($key == 0 && !is_numeric($row[0])) {
                    continue; // se l'id non è un numero significa che il file ha l'intestazione
                }
                //controllo il numero se rientra nei parametri specificati (prefisso e lunghezza)
                $validate = new \App\Services\ValidateAfricanNumber();
                $validationRes = $validate->validate($row[1]);
                $checkPhone = PhoneNumber::where('import_number', $row[1])->first();
                if (!$checkPhone) { // controllo se esiste già il numero altrimenti lo aggiungo
                    $checkModifiedNumber = PhoneNumber::where('number', $validationRes['number'])->where('deleted_at', $validationRes['deleted_at'])->first();
                    if($checkModifiedNumber && $validationRes['number'] != ''){
                        $phoneNumber = new PhoneNumber;
                        $phoneNumber->import_id = $row[0];
                        $phoneNumber->import_number = $row[1];
                        $phoneNumber->note = "Il numero è stato modificato ma risulta già presente a sistema";
                        $phoneNumber->state = 'duplicate';
                        $phoneNumber->number = $validationRes['number'];
                        $phoneNumber->deleted_at = $validationRes['deleted_at'];
                        $phoneNumber->save();
                    }else{
                        $phoneNumber = new PhoneNumber;
                        $phoneNumber->import_id = $row[0];
                        $phoneNumber->import_number = $row[1];
                        $phoneNumber->note = $validationRes['message'];
                        $phoneNumber->state = $validationRes['state'];
                        $phoneNumber->number = $validationRes['number'];
                        $phoneNumber->deleted_at = $validationRes['deleted_at'];
                        $phoneNumber->save();
                    }

                }
            }
        }
        return redirect()->route('showNumber');
    }
    public function validateNumber(Request $request)
    {
        $request->validate([
            'number' => 'required|string|min:9|max:11',
        ]);
        $validate = new \App\Services\ValidateAfricanNumber();
        $validationRes = $validate->validate($request->input('number'));
        return $validationRes;
    }
}
