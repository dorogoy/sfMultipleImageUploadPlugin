<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of utils
 *
 * @author leny
 */
class PluginUtils {
    static public function slugify($text) {
        // replace all non letters or digits by -
        $text = preg_replace('/\W+/', '-', $text);

        // trim and lowercase
        $text = strtolower(trim($text, '-'));

        return $text;
    }

    static public function light_image($thumb_url, $image_url, $image_link_options = array(), $thumb_options = array() )
    {
      //make lightbox effect
      $thumb_tag = image_tag($thumb_url, $thumb_options);

      $image_link_options['class'] = isset($image_link_options['class']) ? $image_link_options['class']." lightbox" : 'lightbox';

      echo link_to($thumb_tag, $image_url, $image_link_options);
    }

    static public function light_image_activate()
    {
      if (!sfContext::hasInstance()) return;

      //add resources
      $response = sfContext::getInstance()->getResponse();

      //check if jqueryreloaded plugin is activated
      if (sfConfig::has('sf_jquery_web_dir') && sfConfig::has('sf_jquery_core'))
        $response->addJavascript(sfConfig::get('sf_jquery_web_dir'). '/js/'.sfConfig::get('sf_jquery_core'));
      else
        throw new Exception("Theres is no JqueryReloaded plugin !");

      //JQuery Lightbox specific
      $response->addJavascript(sfConfig::get("app_sf_jquery_lightbox_js_dir").'jquery.lightbox-0.5.js');
      $response->addStylesheet(sfConfig::get("app_sf_jquery_lightbox_css_dir").'jquery.lightbox-0.5.css');

      $code = "$(function() {
        $('a.lightbox').lightBox({
          imageLoading: '".sfConfig::get('app_sf_jquery_lightbox_imageLoading')."',
          imageBtnClose: '".sfConfig::get('app_sf_jquery_lightbox_imageBtnClose')."',
          imageBtnPrev: '".sfConfig::get('app_sf_jquery_lightbox_imageBtnPrev')."',
          imageBtnNext: '".sfConfig::get('app_sf_jquery_lightbox_imageBtnNext')."',
          imageBlank: '".sfConfig::get('app_sf_jquery_lightbox_imageBlank')."',
          txtImage: '".sfConfig::get('app_sf_jquery_lightbox_txtImage')."',
          txtOf: '".sfConfig::get('app_sf_jquery_lightbox_txtOf')."' });
      });";

      echo javascript_tag($code);
    }
}
?>
