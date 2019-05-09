<?php
use Omega\Utils\Upgrade\OmegaUpgrader;
use Omega\Utils\Upgrade\ScriptResult;
use Illuminate\Support\Facades\Artisan;

return OmegaUpgrader::toVersion('v1.0.3')->postUpgrade(function(ScriptResult $result) {
    try {
        $result->message('Start migrate');
        Artisan::call('migrate');
        $result->message('Migrate : [ OK ]');
    }
    catch(Exception $e) {
        $result->exception($e);
        $result->failed();
    }
    return $result;
});
