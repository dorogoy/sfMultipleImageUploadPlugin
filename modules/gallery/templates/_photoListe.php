<?php use_stylesheet("../sfMultipleImageUploadPlugin/css/photos.css") ?>
<?php use_helper('I18N') ?>
<script>
    function titlize(id){
        $('.editable').hide();
        if(!$('#'+id).hasClass('clicked')){
            $('.editable').removeClass('clicked');
            $('#'+id).show().addClass('clicked');
        }else{
            $('.editable').removeClass('clicked');
        }
    }

    function saveTitle(id){
        var title = $('#' + id + '_value').val();
        $.post('/backend.php/photos/updateTitle',
            {id: id, title : title},
            function(data){
                $('#ajax-loader').show();
                $('#sf_admin_container').prepend("<div class='notice'>"+data+"</div>");
                setTimeout(function(){
                    $("#ajax-loader").slideUp()
                }, 1000);
                $('.editable').hide();
            $('.editable').removeClass('clicked');
            });
    }

    function ajaxPhotoEdition(url){
        $.post(url,
            {},
            function(data){
                $("#pictures_list").html(data);
            });
    }
</script>
<table border="0" width="100%" cellpadding="0" cellspacing="0" id="gallery_content">
    <tr>
        <th rowspan="3"></th>
        <th class="gallery_topleft"></th>
        <td id="gallery_tbl-border-top">&nbsp;</td>
        <th class="gallery_topright"></th>
        <th rowspan="3"></th>
    </tr>
    <tr>
        <td id="gallery_tbl-border-left"></td>
        <td>
            <!--  start content-table-inner ...................................................................... START -->
            <div id="gallery_content-table-inner">

                <!--  start table-content  -->
                <div id="gallery_table-content" style="min-height: 0px;">
                    <?php if($photos->count() > 0): ?>
                        <?php foreach( $photos as $i=>$photo ): ?>
                        <div id="photo-<?php echo $photo->getId()?>" class="picture"  onclick="$(this).find('.actions').toggle();" onmouseover="$(this).find('.actions').show();" onmouseout="$(this).find('.actions').hide();">
                            <?php if($photo->getIsDefault()){ ?> <div id="default" title="<?php echo __('This picture is the image used for the gallery cover') ?>"></div><?php } ?>
                            <img class="basic" src="/uploads/gallery/thumbnail/50_<?php echo $photo->getPicpath(); ?>"/>
                          <div class="actions">
                            <?php if(!$photo->getIsDefault()): ?>

                            <a href="#" onclick="ajaxPhotoEdition('<?php echo url_for('photo_ajax_default', $photo) ?>')" class="default"><img src="/sfMultipleImageUploadPlugin/images/starrize.png" align="left" title="<?php echo __('Use this picture as a cover photo') ?>" /></a>
                            <a href="#" onclick="ajaxPhotoEdition('<?php echo url_for('photo_ajax_delete', $photo) ?>')" class="delete"><img src="/sfMultipleImageUploadPlugin/images/trash.png" align="left" title="<?php echo __('Delete') ?>"/></a>
                            <img onclick="titlize('<?php echo $photo->getId(); ?>_editable');" src="/sfMultipleImageUploadPlugin/images/titlize.png" align="left" title="<?php echo __('Update the title') ?>"/>
                            <?php endif; ?>
                          </div>
                        </div>
                    <div style="background: none repeat scroll 0 0 #F3F3F3; border: 1px dashed #5D5D5D; clear: both; display: none; margin-top: 15px; padding: 5px;" id="<?php echo $photo->getId(); ?>_editable" class="editable">
                        <div style="float: right"><img class="basic" src="/uploads/gallery/thumbnail/50_<?php echo $photo->getPicpath(); ?>"/></div>
                        <p><?php echo __('Enter a description for the selected image') ?></p>
                        <input id="<?php echo $photo->getId()."_value" ?>" type="textarea" value="<?php echo $photo->getTitle() ?>"/>
                        <input onclick="saveTitle(<?php echo $photo->getId();?>)" type="button" value="OK"/></div>
                    
                        <?php endforeach; ?>
                        <div class="clear"></div>
                        <?php else: ?>
                        <p>No photo yet.</p>
                        <?php endif; ?>
                </div>
                <!--  end table-content  -->

                <div class="clear"></div>

            </div>
            <!--  end content-table-inner ............................................END  -->
        </td>
        <td id="gallery_tbl-border-right"></td>
    </tr>
    <tr>
        <th class="gallery_sized bottomleft"></th>
        <td id="gallery_tbl-border-bottom">&nbsp;</td>
        <th class="gallery_sized bottomright"></th>
    </tr>
</table><br/>

