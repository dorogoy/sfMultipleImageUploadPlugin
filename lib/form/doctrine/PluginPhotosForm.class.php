<?php

/**
 * PluginPhotos form.
 *
 * @package    ##PROJECT_NAME##
 * @subpackage form
 * @author     ##AUTHOR_NAME##
 * @version    SVN: $Id: sfDoctrineFormPluginTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
abstract class PluginPhotosForm extends BasePhotosForm
{

      public function setup()
      {
        parent::setup();
        $this->removeFields();

        $this->widgetSchema->setLabels(array(
                    'title' => 'Titre :',
                    'picpath' => 'Chemin <em>*</em>:',
        ));

        $this->widgetSchema['picpath'] = new sfWidgetFormInputFileEditable(array(
                        'label'     => 'Image :',
                        'file_src'  => sfConfig::get('sf_upload_dir').'gallery/thumbnail/150_'.$this->getObject()->getPicpath(),
                        'is_image'  => true,
                        'edit_mode' => !$this->isNew(),
                        'template'  => '<div>%file%<br />%input%<br />%delete% %delete_label%</div>',
        ));

        $this->disableCSRFProtection();
    }

    protected function removeFields() {
        unset(
                $this['created_at'], $this['updated_at']
        );
    }

    public function generatePicpathFilename(sfValidatedFile $file) {
        return $file->getOriginalName();
    }

    protected function doSave ( $con = null ) {
        parent::doSave($con);

        $filename = $this->getObject()->getPicpath();
        $ext = explode(".", $filename);
        $ext = $ext[count($ext)-1];
        if($ext == "JPG") $ext = "jpg";
        // Create the thumbnail
        $img = new sfImage(sfConfig::get("sf_upload_dir")."/".$filename, 'image/'.$ext);
        $img->resize(null,300);
        $img->setQuality(100);
        $img->saveAs(sfConfig::get("sf_upload_dir").'/thumbnail/300_'.$filename, 'image/'.$ext);
        $img->resize(null,150);
        $img->setQuality(80);
        $img->saveAs(sfConfig::get("sf_upload_dir").'/thumbnail/150_'.$filename, 'image/'.$ext);
        $img->resize(null,50);
        $img->setQuality(50);
        $img->saveAs(sfConfig::get("sf_upload_dir").'/thumbnail/50_'.$filename, 'image/'.$ext);
    }
}
