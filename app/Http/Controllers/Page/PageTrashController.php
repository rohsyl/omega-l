<?php

namespace Omega\Http\Controllers\Page;

use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Omega\Http\Controllers\Controller;
use Omega\Models\Page;

class PageTrashController extends Controller
{

    #region trash
    /**
     * Get the page that display the content of the trash
     * @return Factory|View
     */
    public function trash()
    {
        return view('pages.trash')->with([
            'pages' => Page::onlyTrashed()->orderBy('deleted_at', 'DESC')->paginate(config('omega.page.trash.paginate'))
        ]);
    }

    /**
     * Restore a page by id
     * @param $id int The id of the page
     * @return RedirectResponse
     */
    public function restore($id)
    {
        Page::onlyTrashed()->find($id)->restore();
        toast()->success(__('Page restored succesfully!'));
        return redirect()->route('admin.pages.edit', ['id' => $id]);
    }

    /**
     * Delete permanently a page by id
     * @param $id int The id of the page
     * @return RedirectResponse
     */
    public function forcedelete($id)
    {
        $page = Page::onlyTrashed()->find($id);
        $page->modules()->forceDelete();
        $page->forceDelete();
        toast()->success(__('Page deleted permanently!'));
        return redirect()->route('admin.pages.trash');
    }
    #endregion
}
