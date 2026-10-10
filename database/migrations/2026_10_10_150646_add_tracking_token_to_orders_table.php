<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->string('tracking_token', 64)->nullable()->unique();
        });

        DB::table('orders')
            ->select('id')
            ->orderBy('id')
            ->each(function ($order) {
                DB::table('orders')
                    ->where('id', $order->id)
                    ->update([
                        'tracking_token' => Str::random(64),
                    ]);
            });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropUnique(['tracking_token']);
            $table->dropColumn('tracking_token');
        });
    }
};