<?php

namespace Omega\Http\Controllers\Page;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Omega\Http\Controllers\Controller;
use Omega\Models\Page;
use Omega\Policies\OmegaGate;

class PageEnableController extends Controller
{
    #region enable_disable
    /**
     * Enable or disable the given page
     * @param $id int The id of the page
     * @param $enable boolean
     * @return RedirectResponse
     */
    public function enable($id, $enable)
    {
        if (OmegaGate::denies('page_disable'))
            return OmegaGate::redirectBack();

        $page = Page::find($id);
        $page->isEnabled = $enable;
        $page->save();
        toast()->success($enable ? __('Page enabled') : __('Page disabled'));
        return redirect()->back();
    }
    #endregion
}
