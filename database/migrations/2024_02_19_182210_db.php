<?php

use App\Models\Chirp;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
// on cascade
return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->string('name');
        });

        Schema::create('chirps', function (Blueprint $table) {
            $table->id();
            $table->text('content');
            $table->dateTime('date_added')->useCurrent();
            $table->integer('likes_counter')->default(0);
            $table->foreignIdFor(User::class)->constrained();
        });

        Schema::create('likes', function (Blueprint $table) {
            $table->foreignIdFor(User::class)->constrained()->onDelete('cascade');
            $table->foreignIdFor(Chirp::class)->constrained()->onDelete('cascade');
        });

        Schema::create('followers', function (Blueprint $table) {
            $table->unsignedBigInteger('followed_id');
            $table->unsignedBigInteger('follower_id');

            $table->foreign('followed_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('follower_id')->references('id')->on('users')->onDelete('cascade');
        });

        Schema::create('user_roles', function (Blueprint $table) {
            $table->foreignIdFor(User::class)->constrained()->onDelete('cascade');
            $table->foreignIdFor(Role::class)->constrained()->onDelete('cascade');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->integer('followers_counter')->default(0);
            $table->integer('following_counter')->default(0);
        });

        Role::create(['name' => 'ROLE_USER']);
        Role::create(['name' => 'ROLE_ADMIN']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
