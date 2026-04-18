<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Reset bday values because old data may cause MySQL cast errors
        \Illuminate\Support\Facades\DB::table('members')->update(['bday' => null]);

        Schema::table('members', function (Blueprint $table) {
            $table->date('bday')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('members', function (Blueprint $table) {
            $table->string('bday')->nullable()->change();
        });
    }
};
