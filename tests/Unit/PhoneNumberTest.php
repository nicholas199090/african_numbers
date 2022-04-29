<?php

namespace Tests\Unit;

use App\Services\ValidateAfricanNumber;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class PhoneNumberTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_phone_number_import() //test le varie funzioni della classe ValidateAfricanNumber
    {
        $validator = new ValidateAfricanNumber();
        $this->assertNotFalse($validator->isValid('27123456789'));
        $this->assertFalse($validator->isValid('2712345678912345'));
        $this->assertFalse($validator->isValid('27aaaaaaaaa'));
        $this->assertFalse($validator->isValid('26123456789'));
        $this->assertFalse($validator->isValid('27836826107_DELETED_1488996550'));
        $this->assertFalse($validator->isValid('_DELETED_1488996550'));
        $this->assertFalse($validator->isValid('81391685288'));
        $this->assertFalse($validator->isValid('aaaaaaaaa'));
        $this->assertTrue($validator->wrongPrefix('26123456789'));
        $this->assertFalse($validator->wrongPrefix('27836826107_DELETED_1488996550'));
        $this->assertTrue($validator->wrongPrefix('81391685288'));
        $this->assertTrue($validator->wrongPrefix('aaaaaaaaa'));
        $this->assertTrue($validator->checkLength('813916852'));
        $this->assertFalse($validator->checkLength('aaaaaaaaa'));
        $this->assertFalse($validator->checkLength('27836826107_DELETED_1488996550'));
        $this->assertFalse($validator->checkLength('27123456789'));
        $this->assertFalse($validator->checkLength('2712345678912345'));
        $this->assertFalse($validator->isDeleted('27123456789'));
        $this->assertFalse($validator->isDeleted('2712345678912345'));
        $this->assertFalse($validator->isDeleted('aaaaaaaaa'));
        $this->assertFalse($validator->isDeleted('813916852'));
        $this->assertTrue($validator->isDeleted('27836826107_DELETED_1488996550'));
        $this->assertFalse($validator->isDeleted('_DELETED_1488996550'));
    }

    public function test_phone_number_input()
    {
        $response = $this->post('/validate',[
            'number' => '27123456789'
        ]);

        $this->assertArrayHasKey('number',$response);
        $this->assertArrayHasKey('message',$response);
        $this->assertArrayHasKey('state',$response);
    }



}
