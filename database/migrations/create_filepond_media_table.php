<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('filepond_media', function (Blueprint $table) {
            $table->id();

            $table->uuid()->unique();
            $table->string('disk');
            $table->string('path');

            $table->timestamps();
        });
    }
};
