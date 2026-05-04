<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        DB::table('users')->whereNull('role')->update(['role' => User::ROLE_GUEST]);

        Schema::table('users', function (Blueprint $table) {
            $table->unsignedSmallInteger('role')->default(User::ROLE_GUEST)->nullable(false)->change();
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->unsignedSmallInteger('role')->nullable()->default(null)->change();
        });
    }
};
