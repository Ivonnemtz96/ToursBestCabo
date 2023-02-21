<section class="trending pt-6 pb-0 bg-lgrey">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="destination-list">
                    <?php
                $toursData = $db->getAllRecords('tours', '*', ' ORDER BY nombre ASC');
                if (count($toursData) > 0) {
                    $y    =    '';
                    foreach ($toursData as $tour) {
                        $catSel = $db->getAllRecords('toursCate', '*', 'AND id=' . $tour['categoria'] . '', 'LIMIT 1')[0];
                ?>
                    <div class="trend-full bg-white rounded box-shadow overflow-hidden p-4 mb-4">
                        <div class="row">
                            <div class="col-lg-4 col-md-3">
                                <div class="trend-item2 rounded">
                                    <a href="/tour?id=<?php echo ($tour['id']); ?>"
                                        style="background-image: url(/upload/tours/<?php echo (strftime("%Y/%m", strtotime(($tour['fr'])))); ?>/<?php echo ($tour['fPortada']) ?>.jpg);"></a>
                                    <div class="color-overlay"></div>
                                </div>
                            </div>
                            <div class="col-lg-5 col-md-6">
                                <div class="trend-content position-relative text-md-start text-center">
                                    <small><?php echo ($tour['duracion']); ?> hours</small>
                                    <h3 class="mb-1">
                                        <a href="/tour?id=<?php echo ($tour['id']); ?>"><?php echo ($tour['nombre_ingles']); ?>
                                            hours
                                        </a>
                                    </h3>
                                    <h6 class="theme mb-0"></i> <?php echo ($catSel['nombreIn']); ?></h6>
                                    <p class="mt-2 mb-0">
                                        <?php echo substr(strip_tags($tour['descripcion_ingles']), 0, 130); ?>...
                                    </p>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-3">
                                <div class="trend-content text-md-end text-center">
                                    <div class="rating">
                                        <span class="fa fa-star checked"></span>
                                        <span class="fa fa-star checked"></span>
                                        <span class="fa fa-star checked"></span>
                                        <span class="fa fa-star checked"></span>
                                        <span class="fa fa-star checked"></span>
                                    </div>
                                    <div class="trend-price my-2">
                                        <span class="mb-0">From</span>
                                        <h3 class="mb-0">$<?php echo number_format($tour['precioPromo'], 2); ?></h3>
                                        <small>Per adult</small>
                                    </div>
                                    <a href="/tour?id=<?php echo ($tour['id']); ?>" class="nir-btn">View More</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <?php
                    }
                }
                ?>

                </div>
            </div>

        </div>
    </div>
</section>