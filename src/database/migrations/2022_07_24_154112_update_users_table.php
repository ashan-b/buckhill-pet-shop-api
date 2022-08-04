<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table(
            'users',
            function (Blueprint $table) {
                $table->char('uuid', 36)->unique();

                $table->string('name', 255)->default('')->change();
                $table->renameColumn('name', 'first_name');

                $table->string('last_name', 255)->default('');
                $table->boolean('is_admin')->default(0);
                $table->char('avatar', 36)->default('')->nullable();

                /*
                :: Splitting the address field for better categorization ::
                It's better to break up city, country and state in to tables and refer their ids as a relation.
                Skipping that to maintain the simplicity.
                */
                $table->string('address_title', 255)->default('')->nullable();
                $table->string('address_line_1', 255)->default('')->nullable();
                $table->string('address_line_2', 255)->default('')->nullable();
                $table->string('address_line_3', 255)->default('')->nullable();
                $table->string('address_line_4_city', 128)->default('')->nullable();
                $table->string('address_line_5_state', 128)->default('')->nullable();
                $table->string('address_line_6_zip', 32)->default('')->nullable();
                $table->string('address_line_7_country', 128)->default('')->nullable();


                $table->string('phone_number_country_code', 16)->default('')->nullable();
                $table->string('phone_number', 255)->default('')->nullable();

                $table->boolean('is_marketing')->default(0);
                $table->timestamp('last_login_at')->nullable();

            }
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table(
            'users',
            function (Blueprint $table) {

                $table->dropColumn(
                    [
                        'uuid',
                        'last_name',
                        'is_admin',
                        'avatar',
                        'address_title',
                        'address_line_1',
                        'address_line_2',
                        'address_line_3',
                        'address_line_4_city',
                        'address_line_5_state',
                        'address_line_6_zip',
                        'address_line_7_country',
                        'phone_number_country_code',
                        'phone_number',
                        'is_marketing',
                        'last_login_at',
                    ]
                );


                $table->renameColumn('first_name', 'name');
            }
        );
    }
};
