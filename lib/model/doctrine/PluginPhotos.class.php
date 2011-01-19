<?php

/**
 * PluginPhotos
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @package    operation-caribou
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 6820 2009-11-30 17:27:49Z jwage $
 */
abstract class PluginPhotos extends BasePhotos
{
  public function isDefault()
  {
    return (bool) $this->getIsDefault();
  }
  public function  save(Doctrine_Connection $conn = null) {
        parent::save($conn);
        $filename = $this->getPicpath();
        $ext = explode(".", $filename);
        $ext = $ext[count($ext)-1];
        if($ext == "JPG") $ext = "jpg";
        // Create the thumbnail
        $img = new sfImage(sfConfig::get("sf_upload_dir")."/casa/".$filename, 'image/'.$ext);
        $img->resize(null,300);
        $img->setQuality(100);
        $img->saveAs(sfConfig::get("sf_upload_dir").'/casa/thumbnail/300_'.$filename, 'image/'.$ext);
        $img->resize(null,150);
        $img->setQuality(80);
        $img->saveAs(sfConfig::get("sf_upload_dir").'/casa/thumbnail/150_'.$filename, 'image/'.$ext);
        $img->resize(null,50);
        $img->setQuality(50);
        $img->saveAs(sfConfig::get("sf_upload_dir").'/casa/thumbnail/50_'.$filename, 'image/'.$ext);

  }
}