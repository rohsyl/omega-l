<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSpOmUserHasRight extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared('
DROP PROCEDURE IF EXISTS `om_UserHasRight`;
CREATE PROCEDURE `om_UserHasRight`(IN `_rightName` VARCHAR(64), IN `_userId` int(32), OUT `_hasRight` int(1))
BEGIN

	SET @rightId = 0;
	SET @userId = _userId;
    
	SELECT id INTO @rightId FROM rights
		WHERE name = _rightName;

	SELECT COUNT(1) INTO _hasRight FROM 
	(
		SELECT 1 FROM userrights
			WHERE fkUser = @userId 
			AND fkRight = @rightId 
		UNION
		SELECT 1 FROM grouprights
			WHERE fkRight = @rightId 
			AND fkGroup IN 
		(
			SELECT fkGroup FROM usergroups
				WHERE fkUser = @userID
		)
	) as t;
    
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
        DB::unprepared('DROP PROCEDURE IF EXISTS `om_UserHasRight`;');
    }
}
