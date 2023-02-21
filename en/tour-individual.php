<div class="banner trending overflow-hidden">
    <div class="section-shape section-shape1 top-inherit bottom-0" style="background-image: url(/images/shape8.png);">
    </div>
    <div class="banner-slide">
        <div class="row shop-slider">


            <?php $fotosData = $db->getAllRecords('fotosTours', '*', 'AND tour=' . ($tour['id']) . '', 'ORDER BY id DESC LIMIT ' . ($tour['fotosCount']) . '');
                if (count($fotosData) > 0) {
                    $y    =    '';
                    foreach ($fotosData as $foto) {
                        $y++;

                ?>

            <div class="col-lg-5 p-0">
                <div class="trend-item1 box-shadow bg-white text-center">
                    <div class="trend-image position-relative">
                        <img src="/upload/tours/<?php echo (strftime("%Y/%m", strtotime(($tour['fr'])))); ?>/<?php echo ($foto['codigo']) ?>.jpg"
                            alt="image" class="">
                        <div class="overlay"></div>
                    </div>
                </div>
            </div>

            <?php

                    }
                }
                ?>


        </div>
    </div>
    <div class="banner-breadcrum position-absolute top-50 mx-auto w-50 start-50 text-center translate-middle">
        <div class="breadcrumb-content text-center">
            <h1 class="mb-0 white"><?php echo $tour['nombre_ingles']; ?></h1>
            <nav aria-label="breadcrumb" class="d-block">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><?php echo $catSel['nombreIn']; ?></li>
                </ul>
            </nav>
        </div>
    </div>
</div>



<section class="trending pt-6 pb-0 bg-lgrey">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <div class="single-content">
                    <div id="highlight">
                        <div class="description-images mb-4">
                            <img src="/upload/tours/<?php echo (strftime("%Y/%m", strtotime(($tour['fr'])))); ?>/<?php echo ($tour['fPortada']) ?>.jpg"
                                alt="" class="w-100 rounded">
                        </div>
                        <div class="description mb-2">
                            <h4>Description</h4>
                            <p><?php echo ($tour['descripcion_ingles']) ?></p>
                        </div>

                        <div class="description mb-2">
                            <div class="row">


                                <div class="col-lg-12 col-md-12 mb-2">
                                    <div class="desc-box bg-grey p-4 rounded">
                                        <h5 class="mb-2">Recommendations</h5>
                                        <ul>
                                            <?php $carData = $db->getAllRecords('umRecoentour', '*', 'AND tour=' . ($tour['id']) . '', 'ORDER BY id ASC LIMIT ' . ($tour['recoCount']) . '');
                                                if (count($carData) > 0) {

                                                    foreach ($carData as $caracteristica) {

                                                        $carSel = $db->getAllRecords('toursReco', '*', 'AND id=' . ($caracteristica['reco']) . '', 'LIMIT 1')[0];
                                                ?>
                                            <li class="d-block pb-1"><i class="fa fa-circle pink mr-1"></i>
                                                <?php echo $carSel['descripcion_ingles']; ?></li>
                                            <?php
                                                    }
                                                }
                                                ?>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="iternary" class="accrodion-grp faq-accrodion mb-4" data-grp-name="faq-accrodion">
                            <div class="accrodion active">
                                <div class="accrodion-title rounded">
                                    <h5 class="mb-0">Itinerary</h5>
                                </div>
                                <div class="accrodion-content" style="display: block;">
                                    <div class="inner">
                                        <?php $carData = $db->getAllRecords('toursItinerario', '*', 'AND tour=' . ($tour['id']) . '', 'ORDER BY id ASC LIMIT ' . ($tour['incluyeCount']) . '');
                                            if (count($carData) > 0) {

                                                foreach ($carData as $caracteristica) {

                                            ?>
                                        <p><?php echo $caracteristica['descripcion']; ?></p>
                                        <?php
                                                }
                                            }
                                            ?>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="description mb-2">
                        <div class="row">

                            <div class="col-lg-6 col-md-6 mb-2">
                                <div class="desc-box bg-grey p-4 rounded">
                                    <h5 class="mb-2">Including</h5>
                                    <ul>
                                        <?php $carData = $db->getAllRecords('umIncluyeentour', '*', 'AND tour=' . ($tour['id']) . '', 'ORDER BY id ASC LIMIT ' . ($tour['incluyeCount']) . '');
                                            if (count($carData) > 0) {

                                                foreach ($carData as $caracteristica) {

                                                    $carSel = $db->getAllRecords('toursIncluye', '*', 'AND id=' . ($caracteristica['incluye']) . '', 'LIMIT 1')[0];
                                            ?>
                                        <li class="d-block pb-1"><i class="fa fa-check pink mr-1"></i>
                                            <?php echo $carSel['descripcion_ingles']; ?></li>
                                        <?php
                                                }
                                            }
                                            ?>
                                    </ul>

                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 mb-2">
                                <div class="desc-box bg-grey p-4 rounded">
                                    <h5 class="mb-2">Not included</h5>
                                    <ul>
                                        <?php $carData = $db->getAllRecords('umRestentour', '*', 'AND tour=' . ($tour['id']) . '', 'ORDER BY id ASC LIMIT ' . ($tour['restCount']) . '');
                                            if (count($carData) > 0) {

                                                foreach ($carData as $caracteristica) {

                                                    $carSel = $db->getAllRecords('toursRest', '*', 'AND id=' . ($caracteristica['rest']) . '', 'LIMIT 1')[0];
                                            ?>
                                        <li class="d-block pb-1"><i class="fa fa-close pink mr-1"></i>
                                            <?php echo $carSel['descripcion_ingles']; ?></li>
                                        <?php
                                                }
                                            }
                                            ?>
                                    </ul>

                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>


            <div class="col-lg-4 ps-lg-4">
                <div class="sidebar-sticky">
                    <div class="list-sidebar">
                        <div class="sidebar-item">

                            <form method="POST" action="/detalles/"
                                class="form-content rounded overflow-hidden bg-title">
                                <input hidden type="text" name="tour" value="<?php echo $tour['id']; ?>">
                                <h4 class="white text-center border-b pb-2">Book this tour</h4>
                                <div class="row">
                                    <div class="col-lg-12 mb-2">
                                        <div class="form-group">
                                            <span class="white pb-1">Date</span>
                                            <input name="fv" type="date">
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group mb-2">
                                            <label class="white">No. of Adults</label>
                                            <div class="input-box">
                                                <i class="flaticon-add-user"></i>
                                                <input name="adultos" type="number" min="1" max="10" value="2">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group mb-2">
                                            <label class="white">No. of kids</label>
                                            <div class="input-box">
                                                <i class="flaticon-add-user"></i>
                                                <input name="menores" type="number" min="0" max="10" value="1">

                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-12">
                                        <div class="form-group mb-0">
                                            <button type="submit" name="submit" value="submit"
                                                class="nir-btn w-100">Send</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <div class="sidebar-item">
                            <h3>More Tours</h3>
                            <div class="sidebar-destination">
                                <div class="row about-slider">



                                    <?php
                                        $toursData = $db->getAllRecords('tours', '*', ' ORDER BY nombre ASC LIMIT 3');
                                        if (count($toursData) > 0) {
                                            $y    =    '';
                                            foreach ($toursData as $tour) {
                                                $catSel = $db->getAllRecords('toursCate', '*', 'AND id=' . $tour['categoria'] . '', 'LIMIT 1')[0];
                                        ?>


                                    <div class="col-lg-4 col-md-6 col-sm-6 mb-4">
                                        <div class="trend-item1">
                                            <div class="trend-image position-relative rounded">
                                                <img src="/upload/tours/<?php echo (strftime("%Y/%m", strtotime(($tour['fr'])))); ?>/<?php echo ($tour['fPortada']) ?>.jpg"
                                                    alt="image">
                                                <div
                                                    class="trend-content d-flex align-items-center justify-content-between position-absolute bottom-0 p-4 w-100 z-index">
                                                    <div class="trend-content-title">
                                                        <h5 class="mb-0"><a href="/tour?id=<?php echo ($tour['id']); ?>"
                                                                class="theme1"><?php echo ($catSel['nombreIn']); ?></a>
                                                        </h5>
                                                        <h4 class="mb-0 white"><?php echo ($tour['nombre']); ?></h4>
                                                    </div>
                                                </div>
                                                <div class="color-overlay"></div>
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
                </div>
            </div>
        </div>
    </div>
</section>