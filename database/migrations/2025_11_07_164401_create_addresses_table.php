<?php

use App\Http\Traits\AuditColumnTrait;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    use AuditColumnTrait, SoftDeletes;    
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('addresses', function (Blueprint $table) {
            $table->id();
             $table->unsignedBigInteger('user_id');

            $table->string('user_type');
            $table->string('village');
            $table->string('road_no')->nullable();
            $table->string('house_no')->nullable();
            $table->string('union')->nullable();
            $table->string('post_office')->nullable();
            $table->string('sub_district')->nullable();
            $table->string('district')->nullable();
            $table->string('division')->nullable();

            $table->timestamps();
            $table->softDeletes();
            $this->addAuditColumns($table);

            $table->index(['user_id', 'user_type']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('addresses');
    }
};
