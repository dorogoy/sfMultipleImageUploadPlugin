sfMultipleImageUploadPlugin
===========================

This Symfony plugin is a modification of the [sfMultipleAjaxUploadGalleryPlugin](http://www.leny-bernard.com/en/blog/show/sfMultipleImageUploadPlugin) by Leny Bernard. It generates a gallery management module in the backend with an ajax multiple photo uploader.

The sfMultipleImageUploadPlugin features are:

* A gallery can be attached to any module.
* The plugin builds only a thumbnail (not three) and has no frontend module.
* The image management has been improved.
	* The changed name of duplicated images is stored in the database.
	* Deleting an image deletes his thumbnail as well.
* Added spanish translation.

Internationalization supports
-----------------------------

en, fr, es

Requirements
------------

To manipulate pictures, you have to install on your server the GD library or imagemagick

Installation
------------

In order to install the plugin sfMultipleImageUploadPlugin

	Download from GitHub, either with git or the package

Add in config/ProjectConfiguration.class.php the line:

	$this->enablePlugins('sfMultipleImageUploadPlugin');

Get the plugin's resources by typing:
 
	$ php symfony plugin:publish-assets

Then clear the cache

	$ php symfony cc

Enable the gallery and photos module in the backend (or whatever you named it).

	/apps/backend/settings.yml

You have to enter if it doesn't already exist this line
	
	all:  
	  .settings:
	    enabled_modules: [gallery, photos]

If it does exists, you just have to add in the list the gallery module like below :

 	all:  
	  .settings:
	    enabled_modules: [myOthersModule, gallery, photos]

You can now access to the gallery and get its awesome functionnalities.
The plugin use an extern library (GD is set by default but you can totally use imagemagick instead) in order to save your photos in 4 widths {50px, 150px, 300px, orignal size} and copy the thumbnail in the /uploads/gallery/thumbnail directory, automatically created
if your upload directory, defined by the symfony configuration sf_upload_dir is different that the default one (/upload), you juste have to create the "thumbnail" dir in the correct directory.

[TO-DO: Add explanation about attaching a gallery to another module]