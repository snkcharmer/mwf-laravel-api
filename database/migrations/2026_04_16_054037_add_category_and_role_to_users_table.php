<?php

use App\Enums\UserRoleEnum;
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
        Schema::table('users', function (Blueprint $table) {
            // categoryId: Adds the foreign key column
            $table->foreignId('category_id')->nullable()->after('id')->constrained('categories')->nullOnDelete();
            
            // role: Using the Enum value for the default
            $table->string('role')->after('email')->default(UserRoleEnum::DataProvider->value);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['category_id']);
            $table->dropColumn(['category_id', 'role']);
        });
    }
};
