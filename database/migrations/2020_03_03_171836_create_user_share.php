<?php

use Illuminate\Database\Schema\Blueprint;
use W7\DatabaseTool\Migrate\Migration;

class CreateUserShare extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		$this->schema->create('user_share', function (Blueprint $table) {
			$table->increments('id');
			$table->integer('sharer_id')->comment('分享者id');
			$table->integer('user_id')->comment('接收分享的用户id');
			$table->integer('document_id');
			$table->integer('chapter_id');
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		 $this->schema->dropIfExists('user_share');
	}
}