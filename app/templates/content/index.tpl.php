<div class="<?php print $data['img-class']; ?>">
    <h1 class="title"><?php print $data['title']; ?></h1>
</div>
<section class="container">

    <?php foreach ($data['services'] as $service_name => $service): ?>

        <article class="container-item">
            <div class="item-img <?php print $service['img-class']; ?>"></div>
            <div class="item-description-container">
                <h3 class="item-name"><?php print $service_name; ?></h3>
                <p><?php print $service['description']; ?></p>
            </div>
        </article>

    <?php endforeach; ?>

</section>
<div class="map">
    <iframe src="<?php print $data['iframe-src']; ?>"></iframe>
</div>