<?php
namespace Omega\Plugin\Menu\Model;

use Omega\Library\Mvc\Model;
use Omega\Library\Database\Dbs;

class ModelMenu extends Model{

    public function findAllElement()
    {
        $stmt = Dbs::select('id', 'moduleName', 'moduleParam')
            ->from('om_module')
            ///////////////////////// ATTENTION //////////////////////////
            ->where('fkPlugin', '=', '(SELECT id FROM om_plugin WHERE plugName LIKE \'menu\')')
            ///////////////////////// ATTENTION //////////////////////////
            ->run();

        return $stmt;
    }

    public function findElement($id)
    {
        $stmt = Dbs::select('id', 'moduleName', 'moduleParam')
            ->from('om_module')
            ->where('id', '=', $id)
            ->run();

        return $stmt->getRow(0);
    }

    public function findAllMenu()
    {
        $stmt = Dbs::select('id', 'menuName')
            ->from('om_menu')
            ->where('menuIsEnabled', '=', 1)
            ->andwhere('menuIsMain', '=', 0)
            ->run();

        return $stmt;
    }

    public function deleteElement($id)
    {
        $result = Dbs::delete('om_module')
            ->where('id', '=', Dbs::prepareInt($id))
            ->run();

        return $result;
    }
}