<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('marco_analytics', function (Blueprint $table) {
            $table->id();
            $table->string('url');
            $table->string('browser');
            $table->string('device');
            $table->ipAddress('ip_address')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('marco_analytics');
    }
};
