<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->unsignedTinyInteger('chopsticks_quantity')
                ->default(0)
                ->after('payment_method');
        });

        $chopsticksModifierId = DB::table('modifiers')
            ->where('slug', 'chopsticks')
            ->value('id');

        if ($chopsticksModifierId) {
            DB::table('product_modifiers')
                ->where('modifier_id', $chopsticksModifierId)
                ->delete();
        }
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('chopsticks_quantity');
        });
    }
};
