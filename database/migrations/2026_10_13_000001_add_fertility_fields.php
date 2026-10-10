<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('services', function (Blueprint $t) {
            $t->string('kind', 20)->default('treatment')->after('section'); // treatment | condition
            $t->boolean('is_featured')->default(false)->after('is_published');
            $t->boolean('is_educational')->default(true)->after('is_featured');
            $t->text('who_for')->nullable()->after('body');
            $t->text('steps')->nullable()->after('who_for');
            $t->text('considerations')->nullable()->after('steps');
        });

        Schema::table('faqs', function (Blueprint $t) {
            $t->unsignedBigInteger('service_id')->nullable()->index()->after('section');
        });
    }

    public function down(): void
    {
        Schema::table('faqs', fn (Blueprint $t) => $t->dropColumn('service_id'));
        Schema::table('services', fn (Blueprint $t) => $t->dropColumn(['kind', 'is_featured', 'is_educational', 'who_for', 'steps', 'considerations']));
    }
};
