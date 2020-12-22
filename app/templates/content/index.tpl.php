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
    <iframe src="https://maps.google.com/maps?width=100%25&amp;height=300&amp;hl=en&amp;q=Sauletekio%20al.%2015+(Spots%20Club)&amp;t=&amp;z=14&amp;ie=UTF8&amp;iwloc=B&amp;output=embed"></iframe>
</div>