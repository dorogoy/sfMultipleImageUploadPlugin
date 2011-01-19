<?php

require_once dirname(__FILE__) . '/../lib/galleryGeneratorConfiguration.class.php';
require_once dirname(__FILE__) . '/../lib/galleryGeneratorHelper.class.php';

/**
 * gallery actions.
 *
 * @package    operation-caribou
 * @subpackage gallery
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class galleryActions extends autoGalleryActions {

    public function executeUpload(sfWebRequest $request) {
        $this->gallery = Doctrine::getTable("gallery")->find($request->getParameter("gallery_id"));
        $this->forward404unless($this->gallery);

        // list of valid extensions, ex. array("jpeg", "xml", "bmp")
        $allowedExtensions = array("jpeg","png","gif","bmp","jpg");
        // max file size in bytes
        $sizeLimit = 6 * 1024 * 1024;

        $uploader = new qqFileUploader($allowedExtensions, $sizeLimit);

        if(!is_dir(sfConfig::get("sf_upload_dir")."/gallery/")){
            mkdir(sfConfig::get("sf_upload_dir")."/gallery/");
            mkdir(sfConfig::get("sf_upload_dir")."/gallery/thumbnail/");
        }

        $result = $uploader->handleUpload(sfConfig::get("sf_upload_dir")."/gallery/");
        
        // to pass data through iframe you will need to encode all html tags

        /*****************************************************************/

        $file = $request->getParameter("qqfile");
        if(isset($result["success"])){
            $photo = new Photos();
            $photo->setGalleryId($this->gallery->getId());
            $photo->setPicPath($file);
            $photo->setIsDefault(($this->gallery->getPhotos()->count() > 0) ? false : true);
            $photo->setTitle("");
            $photo->setSlug(PluginUtils::slugify($file).time());
            if ($photo->save()) {
            $ok = 'success';
            }else{
                $ok = "failed";
            }
        }

//        echo htmlspecialchars(json_encode($result), ENT_NOQUOTES);
        return $this->renderText(htmlspecialchars(json_encode($result), ENT_NOQUOTES));
        
    }


    /**
     * ajax pour definir une photo par defaut
     *
     * @param sfWebRequest $request
     */
    public function executeAjaxPhotoDefault(sfWebRequest $request) {
        if ($request->isXmlHttpRequest()) {
            $photo = $this->getRoute()->getObject();
            $gallery = $photo->getGallery();

            $old_default = $gallery->getPhotoDefault();

            $gallery->setPhotoDefaut($photo->getId());

            return $this->renderPartial('gallery/photoListe', array('photos' => $gallery->getPhotos()));
        }
        else {
            $this->redirect404();
        }
    }

    /**
     * ajax pour effacer une photo
     *
     * @param sfWebRequest $request
     */
    public function executeAjaxPhotoDelete(sfWebRequest $request) {
        if ($request->isXmlHttpRequest()) {
            $photo = $this->getRoute()->getObject();
            $gallery = $photo->getGallery();
            $photo_id = $photo->getId();
            $photo->delete();

            return $this->renderPartial('gallery/photoListe', array('photos' => $gallery->getPhotos()));
        }
        else {
            $this->redirect404();
        }
    }

    /**
     * ajax pour avoir la liste des photos
     *
     * @param sfWebRequest $request
     */
    public function executeAjaxPhotoListe(sfWebRequest $request) {
        if ($request->isXmlHttpRequest()) {
            $gallery = Doctrine::getTable('gallery')->find($request->getParameter('gallery_id'));

            return $this->renderPartial('gallery/photoListe', array('photos' => $gallery->getPhotos()));
        }
        else {
            $this->redirect404();
        }
    }
}

/*****************************************************************/


        /**
         * Handle file uploads via XMLHttpRequest
         */
        class qqUploadedFileXhr {
            /**
             * Save the file to the specified path
             * @return boolean TRUE on success
             */
            function save($path) {
                $input = fopen("php://input", "r");
                $temp = tmpfile();
                $realSize = stream_copy_to_stream($input, $temp);
                fclose($input);

                if ($realSize != $this->getSize()){
                    return false;
                }

                $target = fopen($path, "w");
                fseek($temp, 0, SEEK_SET);
                stream_copy_to_stream($temp, $target);
                fclose($target);

                return true;
            }
            function getName() {
                return $_GET['qqfile'];
            }
            function getSize() {
                if (isset($_SERVER["CONTENT_LENGTH"])){
                    return (int)$_SERVER["CONTENT_LENGTH"];
                } else {
                    throw new Exception('Getting content length is not supported.');
                }
            }
        }

        /**
         * Handle file uploads via regular form post (uses the $_FILES array)
         */
        class qqUploadedFileForm {
            /**
             * Save the file to the specified path
             * @return boolean TRUE on success
             */
            function save($path) {
                if(!move_uploaded_file($_FILES['qqfile']['tmp_name'], $path)){
                    return false;
                }
                return true;
            }
            function getName() {
                return $_FILES['qqfile']['name'];
            }
            function getSize() {
                return $_FILES['qqfile']['size'];
            }
        }

        class qqFileUploader {
            private $allowedExtensions = array();
            private $sizeLimit = 10485760;
            private $file;

            function __construct(array $allowedExtensions = array(), $sizeLimit = 10485760){
                $allowedExtensions = array_map("strtolower", $allowedExtensions);

                $this->allowedExtensions = $allowedExtensions;
                $this->sizeLimit = $sizeLimit;

                if (isset($_GET['qqfile'])) {
                    $this->file = new qqUploadedFileXhr();
                } elseif (isset($_FILES['qqfile'])) {
                    $this->file = new qqUploadedFileForm();
                } else {
                    $this->file = false;
                }
            }

            /**
             * Returns array('success'=>true) or array('error'=>'error message')
             */
            function handleUpload($uploadDirectory, $replaceOldFile = FALSE){
                if (!is_writable($uploadDirectory)){
                    return array('error' => "Server error. Upload directory isn't writable.");
                }

                if (!$this->file){
                    return array('error' => 'No files were uploaded.');
                }

                $size = $this->file->getSize();

                if ($size == 0) {
                    return array('error' => 'File is empty');
                }

//                if ($size > $this->sizeLimit) {
//                    return array('error' => 'File is too large');
//                }

                $pathinfo = pathinfo($this->file->getName());
                $filename = $pathinfo['filename'];
                //$filename = md5(uniqid());
                $ext = $pathinfo['extension'];

                if($this->allowedExtensions && !in_array(strtolower($ext), $this->allowedExtensions)){
                    $these = implode(', ', $this->allowedExtensions);
                    return array('error' => 'File has an invalid extension, it should be one of '. $these . '.');
                }

                if(!$replaceOldFile){
                    /// don't overwrite previous files that were uploaded
                    while (file_exists($uploadDirectory . $filename . '.' . $ext)) {
                        $filename .= rand(10, 99);
                    }
                }

                if ($this->file->save($uploadDirectory . $filename . '.' . $ext)){
                    return array('success'=>true);
                } else {
                    return array('error'=> 'Could not save uploaded file.' .
                        'The upload was cancelled, or server error encountered');
                }

            }
        }