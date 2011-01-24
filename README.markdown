sfMultipleImageUploadPlugin
===========================

This Symfony plugin is a modification of the [sfMultipleAjaxUploadGalleryPlugin](http://www.leny-bernard.com/en/blog/show/sfMultipleImageUploadPlugin) by Leny Bernard. It generates a gallery management module in the backend with an ajax multiple photo uploader.

The sfMultipleImageUploadPlugin features are:

* A gallery can be attached to any module.
* The plugin builds only a thumbnail and has no frontend module (yes, this is a feature, you are a developper, right?)
* The changed name of duplicated images is now stored in the database.
* Deleting an image deletes the thumbnail as well.
* Added spanish translation.


TO-DO:

* Add an explanation about attaching a gallery to another module
* Simplify and refactorize the code
* Make the plugin play with sfJqueryReloadedPlugin, to avoid collisions with other jQuery libraries
* Use optionally sfImageTransformPlugin and sfImageTransformExtraPlugin for thumbnails
* Change the order of the images in the gallery with jQuery UI Draggable
* Install in foreign modules with a command line
* Convert to a Symfony2 bundle


Internationalization supports
-----------------------------

en, fr, es

Requirements
------------

To manipulate pictures, you have to install on your server the GD library or imagemagick

License
-------

Please check the LICENSE file

Installation
------------

In order to install the plugin sfMultipleImageUploadPlugin, download from GitHub, either with git or the package.

Add in config/ProjectConfiguration.class.php the line:

	$this->enablePlugins('sfMultipleImageUploadPlugin');

Get the plugin's resources by typing:
 
	$ php symfony plugin:publish-assets

Then clear the cache

	$ php symfony cc

Enable the gallery and photos module in you settings.yml of the backend. Ex: /apps/backend/config/settings.yml

You have to enter these lines if they doesn't already exist:

	all:  
	  .settings:
	    enabled_modules: [gallery, photos]

If they do exists, you just have to add in the list the gallery module like below :

  all:  
	  .settings:
	    enabled_modules: [myOthersModule, gallery, photos]

You can now access the gallery through the backend.
The plugin use an external library (GD is set by default but you can use imagemagick instead) in order to save the thumbnail (50px width) and copy the thumbnail in the /uploads/gallery/thumbnail directory, automatically created
if your upload directory, defined by the symfony configuration sf_upload_dir is different than the default one (/upload), you just have to create the "thumbnail" dir in the correct directory.