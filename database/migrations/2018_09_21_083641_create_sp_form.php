<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateSpForm extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        DB::unprepared('
DROP PROCEDURE IF EXISTS `om_CreateForm`;
CREATE PROCEDURE `om_CreateForm` (IN _name VARCHAR(32), IN _plugin VARCHAR(32), IN _isModule TINYINT, IN _isComponent TINYINT, IN _title VARCHAR(32))
BEGIN
	DECLARE idPlugin INT;
    SELECT id INTO idPlugin FROM plugins WHERE name LIKE _plugin;
    IF( idPlugin IS NOT NULL ) THEN
		INSERT INTO forms VALUES (NULL, _name, _title, _isModule, _isComponent, idPlugin);
	END IF;
END;');
        DB::unprepared('
DROP procedure IF EXISTS `om_CreateFormEntry`;
CREATE PROCEDURE `om_CreateFormEntry`(IN _fname VARCHAR(32), IN _ename VARCHAR(32), IN _order INT, IN _type TEXT, IN _param TEXT, IN _title VARCHAR(32), IN _description TEXT, IN _mandatory TINYINT)
BEGIN
	DECLARE idForm INT;
    SELECT id INTO idForm FROM forms WHERE `name` LIKE _fname;
    IF( idForm IS NOT NULL ) THEN
		INSERT INTO form_entries (`fkForm`, `name`, `type`, `param`, `title`, `description`, `mandatory`, `heading`, `order`)
							VALUES (idForm, _ename, _type, _param, _title, _description, _mandatory, 0, _order);
	END IF;
END;');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        DB::unprepared('DROP PROCEDURE IF EXISTS om_CreateForm;');
        DB::unprepared('DROP PROCEDURE IF EXISTS om_CreateFormEntry;');
    }
}
