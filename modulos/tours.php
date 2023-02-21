<section class="trending pb-0">
    <div class="container">
        <div class="row align-items-center justify-content-between mb-6 ">
            <div class="col-lg-7">
                <div class="section-title text-center text-lg-start">
                    <h4 class="mb-1 theme1">Excurciones y recorridos</h4>
                    <h2 class="mb-1">Nuestors <span class="theme">Tours Top</span></h2>
                    <p>Un viaje para nunca olvidar</p>
                </div>
            </div>
            <div class="col-lg-5">
            </div>
        </div>
        <div class="trend-box">
            <div class="row item-slider">

                <?php
                $toursData = $db->getAllRecords('tours', '*', ' ORDER BY nombre ASC');
                if (count($toursData) > 0) {
                    $y    =    '';
                    foreach ($toursData as $tour) {
                        $catSel = $db->getAllRecords('toursCate', 'nombre', 'AND id=' . $tour['categoria'] . '', 'LIMIT 1')[0];
                ?>


                        <div class="col-lg-4 col-md-6 col-sm-6 mb-4">
                            <div class="trend-item rounded box-shadow">
                                <a href="/tour?id=<?php echo ($tour['id']); ?>">

                                    <div class="trend-image position-relative">
                                        <img src="/upload/tours/<?php echo (strftime("%Y/%m", strtotime(($tour['fr'])))); ?>/<?php echo ($tour['fPortada']) ?>.jpg" alt="image" class="">
                                        <div class="color-overlay"></div>
                                    </div>
                                </a>
                                <div class="trend-content p-4 pt-5 position-relative">
                                    <div class="trend-meta bg-theme white px-3 py-2 rounded">
                                        <div class="entry-author">
                                            <i class="fa-solid fa-clock"></i>
                                            <span class="fw-bold"> <?php echo ($tour['duracion']); ?> horas</span>
                                        </div>
                                    </div>
                                    <h5 class="theme mb-1"><i class="flaticon-location-pin"></i> <?php echo ($catSel['nombre']); ?></h5>
                                    <h3 class="mb-1"><a href="/tour?id=<?php echo ($tour['id']); ?>"><?php echo ($tour['nombre']); ?></a></h3>
                                    <div class="rating-main d-flex align-items-center pb-2">
                                        <div class="rating">
                                            <span class="fa fa-star checked"></span>
                                            <span class="fa fa-star checked"></span>
                                            <span class="fa fa-star checked"></span>
                                            <span class="fa fa-star checked"></span>
                                            <span class="fa fa-star checked"></span>
                                        </div>
                                    </div>
                                    <p class=" border-b pb-2 mb-2"><?php echo substr(strip_tags($tour['descripcion']), 0, 130); ?>...</p>
                                    <div class="entry-meta">
                                        <div class="row entry-author d-flex align-items-center">
                                            <div class="col-md-6">
                                                <p class="mb-0"><span class="theme fw-bold fs-5"> $<?php echo number_format($tour['precioPromo'], 2); ?></span></span>
                                                    <br> <span style="text-decoration:line-through;">$<?php echo number_format($tour['precio'], 2); ?></span> | Adulto
                                                </p>
                                            </div>
                                            <div class="col-md-6">
                                                <p class="mb-0"><span class="theme fw-bold fs-5"> $<?php echo number_format($tour['precioNiPromo'], 2); ?></span>
                                                    <br> <span style="text-decoration:line-through;">$<?php echo number_format($tour['precioNi'], 2); ?></span> | Niño
                                                </p>
                                            </div>
                                        </div>
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
</section>