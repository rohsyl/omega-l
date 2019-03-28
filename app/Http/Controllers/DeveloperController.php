<?php

namespace Omega\Http\Controllers;

use Illuminate\Http\Request;
use Omega\Repositories\DataTypeRepository;

class DeveloperController extends AdminController
{
    private $dataTypeRepository;

    public function __construct(DataTypeRepository $dataTypeRepository) {
        parent::__construct();

        $this->dataTypeRepository = $dataTypeRepository;
    }

    public function getDatatypesHelp(){

        return view('developer.datatype.help')->with([
            'datatypes' => $this->dataTypeRepository->all(),
        ]);
    }
}
