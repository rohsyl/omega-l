<?php
use Omega\Utils\Upgrade\OmegaUpgrader;
use Omega\Utils\Upgrade\ScriptResult;
use Illuminate\Support\Facades\Artisan;

return OmegaUpgrader::toVersion('v1.0.8')->postUpgrade(function(ScriptResult $result) {
    try {
        $result->message('Start migrate');
        Artisan::call('migrate');
        $result->message('Migrate : [ OK ]');

        $result->message('Update config');
        config(['laraupdater.permissions.policy' => Omega\Utils\Upgrade\Policies\OmegaPermissionLaraUpdaterPolicy::class]);
        config(['laraupdater.permissions.parameters.ability' => 'update_cms']);
        $result->message('Config : [ OK ]');
    }
    catch(Exception $e) {
        $result->exception($e);
        $result->failed();
    }
    return $result;
});
