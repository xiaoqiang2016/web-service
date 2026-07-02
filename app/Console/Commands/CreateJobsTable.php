<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

class CreateJobsTable extends Command
{
    protected $signature = 'custom:create-jobs-table';
    protected $description = 'Create the jobs table if it does not exist';

    public function handle()
    {
        if (!Schema::hasTable('jobs')) {
            Schema::create('jobs', function (Blueprint $table) {
                $table->id();
                $table->string('department', 100)->nullable();
                $table->string('location', 100)->nullable();
                $table->string('salary', 100)->nullable();
                $table->string('experience', 100)->nullable();
                $table->string('education', 100)->nullable();
                $table->integer('sort_order')->default(0);
                $table->tinyInteger('is_show')->default(1);
                $table->timestamps();
            });
            $this->info('Jobs table created successfully!');
        } else {
            $this->info('Jobs table already exists.');
        }
    }
}