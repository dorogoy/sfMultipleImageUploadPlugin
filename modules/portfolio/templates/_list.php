<?php $galleries = Gallery::getAllGalleries() ?>

<div class="home topic">
    <?php slot('h1') ?>
    Liste des Portfolios
    <?php end_slot() ?>

    <?php foreach ($galleries as $i=>$gallery): ?>
    <div class="cont">
        <div><a class="title handwrite" href="<?php echo url_for(@showGallery, $gallery) ?>"><h3>
                    <?php echo $gallery->getTitle() ?></h3></a></div>
        <div><a href="<?php echo url_for(@showGallery, $gallery) ?>">
                <img src="/uploads/gallery/thumbnail/150_<?php echo $gallery->getPhotoDefault()->getPicpath() ?>"/>
            </a></div>
    </div>
    <?php endforeach; ?>
</div>
<?php echo count($galleries) >= 4 ? '<div class="clear"></div>' : ""; ?>