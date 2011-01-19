<?php
class PluginBackendPhotosForm extends PluginPhotosForm {
    public function setup()
      {
        parent::setup();

        $this->removeFields();
        $this->widgetSchema->setLabels(array(
                'title' => 'Titre :',
                'gallery_id' => 'Galerie :',
        ));
        $this->widgetSchema['picpath'] = new sfWidgetFormInputFile(array('label' => 'Image'));

    }
    protected function removeFields() {
        unset($this['created_at'], $this['updated_at'], $this['slug'], $this['is_default']);
    }

    public function generatePicpathFilename(sfValidatedFile $file) {
        return $file->getOriginalName();
    }
}
?>
