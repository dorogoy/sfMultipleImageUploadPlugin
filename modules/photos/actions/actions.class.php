<?php

require_once dirname(__FILE__).'/../lib/photosGeneratorConfiguration.class.php';
require_once dirname(__FILE__).'/../lib/photosGeneratorHelper.class.php';

/**
 * photos actions.
 *
 * @package    operation-caribou
 * @subpackage photos
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class photosActions extends autoPhotosActions
{
    public function executeUpdateTitle(sfWebRequest $request){
        if ($request->isXmlHttpRequest()) {
            $id = $request->getParameter('id');
            $title = $request->getParameter('title');
            $photo = Doctrine::getTable('photos')->find($id);
            $photo->setTitle($title);
            $photo->save();
            return $this->renderText('¡La foto se modificó correctamente!');
        }
    }
}
