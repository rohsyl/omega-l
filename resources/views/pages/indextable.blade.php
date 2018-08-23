{{--
use Omega\Library;
use Omega\Library\Util\Util;
use Omega\Library\Util\Url;
use Omega\Library\Language\Front\Lang;
use function Omega\Library\__;

$lPageTitle 		= Library\__('Title', true);
$lPageLastEditor 	= Library\__('Last editor', true);
$lPageCreated 		= Library\__('Created', true);
$lPageUpdated 		= Library\__('Updated', true);
$lPageModel 		= Library\__('Model', true);
$lLang 		        = Library\__('Language', true);
$lPageCssTheme 		= Library\__('Style', true);
$lAllPage 			= Library\__('All pages', true);
$lAddNewPage 		= Library\__('Add new', true);
$lNoPage 			= Library\__('No page', true);
$lTitleLinkEdit 	= Library\__('Edit', true);
$lTitleLinkDelete 	= Library\__('Delete', true);
$lTitleLinkEnable 	= Library\__('Click to enable the page', true);
$lTitleLinkDisable	= Library\__('Click to disable the page', true);

$gIconFile 			= 'glyphicon glyphicon-file';
$gIconPlus 			= 'glyphicon glyphicon-plus-sign';
$gIconEdit	 		= 'glyphicon glyphicon-pencil';
$gIconDelete 		= 'glyphicon glyphicon-trash';
$gIconEnable 		= 'glyphicon glyphicon-ok';
$gIconDisable 		= 'glyphicon glyphicon-remove';

$dateFormat 		= 'd/m/Y H:i:s';

--}}

<table class="table table-hover">
    <tr>
        <th>{{ __('Title') }}</th>
        <th>{{ __('Last editor') }}</th>
        <th>{{ __('Updated') }}</th>
        <th>{{ __('Model') }}</th>
        @if($enabledLang)
        <th>{{ __('Language') }}</th>
        @endif
        <th></th>
    </tr>
    @if(count($pages) == 0)
    <tr>
        <td colspan="@if($enabledLang) 5 @else 4 @endif" align="center">
            {{ __('No page') }}
            @php $args = $enabledLang ? ['lang' => $currentLang] : []; @endphp
            <a href="{{ route('admin.pages.add', $args) }}" class="btn btn-primary btn-xs">
                <span class="glyphicon glyphicon-plus-sign"></span> {{ __('Add new') }}
            </a>
        </td>
    </tr>

    @else
        {{--
    <?php foreach($pages as $page) : ?>

    <tr class="row-page" data-idPage="<?php echo $page->id ?>" data-title="<?php echo $page->pageName ?>">
        <td><a href="<?php echo Url::Action('page', 'edit', array('id' => $page->id)) ?>"><?php echo $page->pageName ?></a></td>
        <td><?php echo $page->owner->userLogin ?></td>
        <td><?php echo date($dateFormat, strtotime($page->pageDateUpdated)) ?></td>
        <td><?php echo Util::toTextClean($page->pageModel) ?></td>

        <?php if($enabledLang): ?>
        <td>
            <?php
            $pageLang = $page->pageLang;
            if(isset($pageLang)) {
                $lang = new Lang($pageLang);
                echo $lang->name;
            }
            else{
                __('Any');
            }
            ?>
        </td>
        <?php endif ?>

        <td>
				<span class="action-img-page-list">
					<a  href="<?php echo Url::Action('page', 'edit', array('id' => $page->id)) ?>"
                        title="<?php Library\__('Edit') ?>"><?php Library\__('Edit') ?></a>
					|
					<a  href="<?php echo Url::Action('page', 'delete', array('id' => $page->id)) ?>"
                        title="<?php echo $lTitleLinkDelete ?>"
                        data-url="<?php echo Url::Action('page', 'delete', array('id' => $page->id, 'confirmed' => true)) ?>"
                        class="delete text-danger"><?php echo $lTitleLinkDelete ?></a>
					|
                    <?php if($page->pageIsEnabled == true) { ?>
                    <a href="<?php echo Url::Action('page', 'disable', array('id' => $page->id)) ?>" title="<?php echo $lTitleLinkDisable ?>"><?php Library\__('Disable') ?></a>
                    <?php } else { ?>
                    <a href="<?php echo Url::Action('page', 'enable', array('id' => $page->id)) ?>" title="<?php echo $lTitleLinkEnable ?>"><?php Library\__('Enable') ?></a>
                    <?php } ?>

				</span>
        </td>
    </tr>
    <?php if($page->children != null && sizeof($page->children) > 0) : ?>
    <?php foreach($page->children as $child) : ?>
    <tr>
        <td><i class="fa fa-minus"></i> <a href="<?php echo Url::Action('page', 'edit', array('id' => $child->id)) ?>"><?php echo $child->pageName ?></a></td>
        <td><?php echo $child->owner->userLogin ?></td>
        <td><?php echo date($dateFormat, strtotime($child->pageDateUpdated)) ?></td>
        <td><?php echo Library\clean_text($child->pageModel) ?></td>

        <?php if($enabledLang): ?>
        <td>
            <?php
            $pageLang = $child->pageLang;
            if(isset($pageLang)) {
                $lang = new Lang($pageLang);
                echo $lang->name;
            }
            else{
                __('Any');
            }
            ?>
        </td>
        <?php endif ?>

        <td>
						<span class="action-img-page-list">
							<a  href="<?php echo Url::Action('page', 'edit', array('id' => $child->id)) ?>"
                                title="<?php Library\__('Edit'); ?>"><?php Library\__('Edit'); ?></a>
							|
							<a  href="<?php echo Url::Action('page', 'delete', array('id' => $child->id)) ?>"
                                title="<?php echo $lTitleLinkDelete ?>"
                                data-url="<?php echo Url::Action('page', 'delete', array('id' => $child->id, 'confirmed' => true)) ?>"
                                class="delete text-danger"><?php echo $lTitleLinkDelete ?></a>
							|
                            <?php if($child->pageIsEnabled == true) : ?>
                            <a href="<?php echo Url::Action('page', 'disable', array('id' => $child->id)) ?>" title="<?php echo $lTitleLinkDisable ?>"><?php Library\__('Disable') ?></a>
                            <?php else : ?>
                            <a href="<?php echo Url::Action('page', 'enable', array('id' => $child->id)) ?>" title="<?php echo $lTitleLinkEnable ?>"><?php Library\__('Enable') ?></a>
                            <?php endif; ?>
						</span>
        </td>
    </tr>
    <?php endforeach; ?>
    <?php endif; ?>
    <?php endforeach; ?>

    --}}
    @endif
</table>