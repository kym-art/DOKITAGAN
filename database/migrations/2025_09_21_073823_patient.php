<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('patients', function (Blueprint $table) {
            // $table->unsignedBigInteger('patient_id')->unique()->primary();
            $table->id('patient_id');
            $table->string('nom'         )->require();
            $table->string('prenom'     );
            $table->string('adress'      );
            $table->string('telephone' );
            $table->string('email'    )->unique();
            $table->string('sex'         );
            $table->string('nationalite');
            $table->string('naissance');
            $table->longtext('antecedant');
            $table->timestamps();
            
            //
        });
            DB::statement('ALTER TABLE patients AUTO_INCREMENT=1050001;');

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('patient', function (Blueprint $table) {
            //
        });
    }
};
