<?php slot('sf_admin.current_header') ?>
<th class="sf_admin_boolean sf_admin_list_th_is_default">
    <p style="font-size: 0em"><?php if ('is_default' == $sort[0]): ?>
    <?php echo link_to(__("Icone", array(), 'messages'), '@photos', array('query_string' => 'sort=is_default&sort_type='.($sort[1] == 'asc' ? 'desc' : 'asc'))) ?>
    <?php echo image_tag(sfConfig::get('sf_admin_module_web_dir').'/images/'.$sort[1].'.png', array('alt' => __($sort[1], array(), 'sf_admin'), 'title' => __($sort[1], array(), 'sf_admin'))) ?>
  <?php else: ?>
    <?php echo link_to(__("Icone", array(), 'messages'), '@photos', array('query_string' => 'sort=is_default&sort_type=asc')) ?>
  <?php endif; ?></p>
</th>
<?php end_slot(); ?>
<?php include_slot('sf_admin.current_header') ?><?php slot('sf_admin.current_header') ?>
<th class="sf_admin_text sf_admin_list_th_gallery">
    <?php if ('gallery_id' == $sort[0]): ?>
    <?php echo link_to(__("Album", array(), 'messages'), '@photos', array('query_string' => 'sort=gallery_id&sort_type='.($sort[1] == 'asc' ? 'desc' : 'asc'))) ?>
    <?php echo image_tag(sfConfig::get('sf_admin_module_web_dir').'/images/'.$sort[1].'.png', array('alt' => __($sort[1], array(), 'sf_admin'), 'title' => __($sort[1], array(), 'sf_admin'))) ?>
  <?php else: ?>
    <?php echo link_to(__("Album", array(), 'messages'), '@photos', array('query_string' => 'sort=gallery_id&sort_type=asc')) ?>
  <?php endif; ?>
</th>
<?php end_slot(); ?>
<?php include_slot('sf_admin.current_header') ?><?php slot('sf_admin.current_header') ?>
<th class="sf_admin_text sf_admin_list_th_picpath">
  <?php if ('picpath' == $sort[0]): ?>
    <?php echo link_to(__('Apercu', array(), 'messages'), '@photos', array('query_string' => 'sort=picpath&sort_type='.($sort[1] == 'asc' ? 'desc' : 'asc'))) ?>
    <?php echo image_tag(sfConfig::get('sf_admin_module_web_dir').'/images/'.$sort[1].'.png', array('alt' => __($sort[1], array(), 'sf_admin'), 'title' => __($sort[1], array(), 'sf_admin'))) ?>
  <?php else: ?>
    <?php echo link_to(__('Apercu', array(), 'messages'), '@photos', array('query_string' => 'sort=picpath&sort_type=asc')) ?>
  <?php endif; ?>
</th>
<?php end_slot(); ?>
<?php include_slot('sf_admin.current_header') ?>