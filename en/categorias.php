<div class="category-main-inner border-t pt-1">
    <div class="row side-slider">


        <?php
        $catSelData = $db->getAllRecords('toursCate', '*', ' ORDER BY nombre ASC');
        if (count($catSelData) > 0) {
            $y    =    '';
            foreach ($catSelData as $categoria) {
        ?>
         <div class="col-lg-3 col-md-6 my-4">
            <div class="category-item box-shadow p-3 py-4 text-center bg-white rounded overflow-hidden">
                <div class="trending-topic-content">
                    <img src="/upload/categorias/<?php echo (strftime("%Y/%m", strtotime(($categoria['fr']))));?>/<?php echo ($categoria['imagen']) ?>.png" class="mb-1 d-inline-block" alt="">
                    <h4 class="mb-0"><a href="/tours"><?php echo ($categoria['nombreIn']); ?></a></h4>
                </div>
            </div>
        </div>
        <?php
            }
        }
        ?>
        
    </div>
</div>