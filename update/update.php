<?php
function laraupdater_post_upgrade($currentVersion, $newlyInstalledVersion) {
    return \Omega\Utils\Upgrade\OmegaUpgrader::upgrade($currentVersion, $newlyInstalledVersion);
}