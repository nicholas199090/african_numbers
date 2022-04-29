<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePhoneNumbersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('phone_numbers', function (Blueprint $table) {
            $table->id();
            $table->string('number')->nullable(); // utilizzo un varchar per flessibilità (se devo inserire in futuro un prefisso o modificare la lunghezza non modifico il db)
            $table->enum('state', ['correct', 'modified','wrong','duplicate'])->default('correct');
            $table->string("import_id"); // mi importo l'id ma ne creo uno autoincrement cosi se ci sono duplicati non ho problemi
            $table->string('import_number'); //tengo traccia del vecchio numero per mostrare le differenze ed avere uno storico
            $table->text('note');
            $table->timestamp('deleted_at')->nullable()->default(null);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('phone_numbers');
    }
}
