<?php
/**
 * Created by PhpStorm.
 * User: rohs
 * Date: 09.10.18
 * Time: 17:24
 */

namespace Omega\Repositories;


use Omega\Models\Membergroup;

class MembergroupRepository
{
    private $membergroup;

    public function __construct(Membergroup $membergroup){
        $this->membergroup = $membergroup;
    }

    public function get($id){
        return $this->membergroup->find($id);
    }

    public function all(){
        return $this->membergroup->get();
    }

    public function create($inputes){
        $mg = new Membergroup();
        $mg->name = unique_slug($mg, $inputes['name'], 'name');
        $mg->save();
        return $mg;
    }

    public function update($membergroup, $inputes){
        $membergroup->name = unique_slug($membergroup, $inputes['name'], 'name');
        $membergroup->save();
        return $membergroup;
    }

    public function delete($id){
        return $this->membergroup->destroy($id);
    }



    public function clearMembers($membergroup){
        $membergroup->members()->detach();
    }

    public function attachMembers($membergroup, $members){
        if(isset($members))
            foreach($members as $memberId){
                $membergroup->members()->attach($memberId);
            }
    }
}