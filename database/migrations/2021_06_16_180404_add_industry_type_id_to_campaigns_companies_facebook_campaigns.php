<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddIndustryTypeIdToCampaignsCompaniesFacebookCampaigns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('campaigns', function (Blueprint $table) {
            $table->integer('industry_type_id')->nullable();
        });

        Schema::table('companies', function (Blueprint $table) {
            $table->integer('industry_type_id')->nullable();
        });

        Schema::table('facebook_campaigns', function (Blueprint $table) {
            $table->integer('industry_type_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('campaigns', function (Blueprint $table) {
            //
        });
    }
}
