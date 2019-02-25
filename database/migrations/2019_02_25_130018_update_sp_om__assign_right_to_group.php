<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class UpdateSpOmAssignRightToGroup extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {        DB::unprepared('
DROP PROCEDURE IF EXISTS `om_AssignRightToGroup`;
CREATE PROCEDURE om_AssignRightToGroup(IN _rightName VARCHAR(64), IN _groupName VARCHAR(64))
BEGIN

	SET @rightId = 0;
	SET @groupId = 0;

	SELECT id INTO @rightId
	FROM rights
	WHERE name = _rightName;

	SELECT id INTO @groupId
	FROM groups
	WHERE name = _groupName;

	INSERT INTO grouprights(fkRight, fkGroup) VALUES(@rightId, @groupId);

END;
        ');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared('
DROP PROCEDURE IF EXISTS `om_AssignRightToGroup`;
CREATE PROCEDURE om_AssignRightToGroup(IN _rightName VARCHAR(64), IN _groupName VARCHAR(64))
BEGIN

	SET @rightId = 0;
	SET @groupId = 0;

	SELECT id INTO @rightId
	FROM rights
	WHERE name = _rightName;

	SELECT id INTO @groupId
	FROM groups
	WHERE name = _groupName;

	INSERT INTO grouprights VALUES(@rightId, @groupId);

END;
        ');
    }
}
