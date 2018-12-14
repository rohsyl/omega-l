@php
global $displayFilesize;
$displayFilesize = $filesize['filesize'];

if(!function_exists('document_get_item_content')){
    function document_get_item_content($media){
        global $displayFilesize;
        $media->readInDbMeta();

        $html = '
        <div class="col-md-6 col-sm-12">
            <div class="document-item">
                <a target="_blank" href="' . asset($media->path) . '">
                    <span class="doc-icon">
                        <i class="' . \OmegaPlugin\document\utils\DocumentUtils::getClassByExt($media->ext) . ' ' . \OmegaPlugin\document\utils\DocumentUtils::getIconByExt($media->ext) . '"></i>
                    </span>
                    <span class="text">';
        if($media->getTitle() != null && !empty($media->getTitle())){
            $html .=  $media->getTitle() . '
                            <span>
                                ' . $media->getDescription() . '
                                ' . ( isset($displayFilesize) && $displayFilesize ? '('.\OmegaPlugin\document\utils\DocumentUtils::formatBytes($media->getFilesize()).')' : '' ) . '
                            </span>';
        }
        else{
            $html .= $media->name.'.'.$media->ext . '
                            ' . ( isset($displayFilesize) && $displayFilesize ? '<span>'.\OmegaPlugin\document\utils\DocumentUtils::formatBytes($media->getFilesize()).'</span>' : '' );
        }
        $html .= '</span>
                </a>
            </div>
        </div>';
        return $html;
    }
}
@endphp

<div class="plugin-document-container" data-plugin-placement="content">
@if(isset($documents))
    <div class="row">
        @foreach($documents as $document)

            @php
            $m = \Omega\Utils\Entity\Media::Get($document['id']);
            $mType = $m->getType();
            if($mType == \Omega\Utils\Entity\Media::T_FOLDER){
                $children = $m->getChildren(array(\Omega\Utils\Entity\Media::T_DOCUMENT));
                foreach($children as $media){
                    echo document_get_item_content($media);
                }
            }
            else{
                echo document_get_item_content($m);
            }
            @endphp
        @endforeach
    </div>
@else
    {{ __('Nothing to display...') }}
@endif
</div>