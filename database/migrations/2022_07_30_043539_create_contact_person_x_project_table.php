<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contact_person_x_project', function (Blueprint $table) {
            $table->foreignId('contact_person_id')->constrained();
            $table->foreignId('project_id')->constrained();
            $table->primary(['contact_person_id', 'project_id']);	
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('contact_person_x_project');
    }
};
