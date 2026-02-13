<?php

// create_users_table.php
Schema::create('users', function (Blueprint $table) {
    $table->uuid('id')->primary();
    $table->string('username')->unique();
    $table->string('email')->unique();
    $table->string('password')->nullable();
    $table->string('name');

    $table->timestamps();
});


// create_users_table.php
Schema::create('user_auth_providers', function (Blueprint $table) {
    $table->uuid('id')->primary();
    $table->uuid('user_id')->index();
    $table->string('provider');
    $table->string('provider_user_id');

    $table->unique(['provider', 'provider_user_id']);
    $table->unique(['user_id', 'provider']);

    $table->timestamps();
});

// create_trips_table.php
Schema::create('trips', function (Blueprint $table) {
    $table->uuid('id')->primary();
    $table->string('title');
    $table->date('start_date');
    $table->boolean('is_private')->default(false);
    $table->timestamps();
});

// create_destinations_table.php
Schema::create('destinations', function (Blueprint $table) {
    $table->uuid('id')->primary();
    $table->string('name');
    $table->timestamps();
});

// create_pois_table.php
Schema::create('pois', function (Blueprint $table) {
    $table->uuid('id')->primary();
    $table->uuid('destination_id');
    $table->string('google_place_id', 100)->nullable()->unique();
    $table->string('name');
    $table->string('image_url', 500)->nullable();
    $table->text('description')->nullable();
    $table->decimal('latitude', 10, 7);
    $table->decimal('longitude', 10, 7);
    $table->timestamps();

    $table->foreign('destination_id')->references('id')->on('destinations')->cascadeOnDelete();
});

// create_trip_days_table.php
Schema::create('trip_days', function (Blueprint $table) {
    $table->uuid('id')->primary();
    $table->uuid('trip_id');
    $table->uuid('destination_id')->nullable();
    $table->smallInteger('day_order')->unsigned()->default(1);
    $table->time('start_time');
    $table->integer('version')->unsigned()->default(1);
    $table->timestamps();

    $table->foreign('trip_id')->references('id')->on('trips')->cascadeOnDelete();
    $table->foreign('destination_id')->references('id')->on('destinations')->nullOnDelete();
    $table->unique(['trip_id', 'day_order']);
});

// create_itinerary_items_table.php
Schema::create('itinerary_items', function (Blueprint $table) {
    $table->uuid('id')->primary();
    $table->uuid('trip_day_id');
    $table->uuid('poi_id')->nullable();
    $table->string('title');
    $table->integer('position')->unsigned();
    $table->smallInteger('duration')->unsigned()->default(0); // in minutes
    $table->tinyInteger('type')->unsigned(); // mapping enum
    $table->timestamps();

    $table->foreign('trip_day_id')->references('id')->on('trip_days')->cascadeOnDelete();
    $table->foreign('poi_id')->references('id')->on('pois')->nullOnDelete();
    $table->unique(['trip_day_id', 'position']);
});


// create_trip_members_table.php
Schema::create('trip_members', function (Blueprint $table) {
    $table->uuid('id')->primary();
    $table->uuid('trip_id');
    $table->uuid('user_id');
    $table->tinyInteger('role')->unsigned(); // mapping enum
    $table->timestamps();

    $table->foreign('trip_id')->references('id')->on('trips')->cascadeOnDelete();
    $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();
    $table->unique(['trip_id', 'user_id']);
});
