<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::create('security_logs', function (Blueprint $table) {
            $table->id();
            $table->string('file_path');
            $table->string('quarantined_path');
            $table->timestamp('detected_at');
            $table->timestamps();
        });
    }
    public function down() {
        Schema::dropIfExists('security_logs');
    }
};
