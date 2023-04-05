<?php

function lagmp_csv_exp_imp_content()
{

    $csv_brand_eporter = site_url() . '/csv-brand-expoter';
    wp_enqueue_media();




?>

    <div class="mt-3 shadow p-3 mb-3 bg-body rounded user-dashboard">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="section-title mt-3 shadow p-3 mb-3 bg-body rounded">
                        <h2>Welcome to CSV Importer</h2>
                        <!-- <h2>Welcome to CSV Exporter and Importer</h2> -->
                    </div>
                </div>
            </div>
            <div class="row">

                <div class="col-5">
                    <div class="csv_exporter_btn shadow p-3 mb-5 bg-body rounded  text-center">
                        <h4 class="mb-4">Download Brand CSV</h4>
                        <div class="export_csv_btn">
                            <a class="btn btn-info" href="<?php echo $csv_brand_eporter; ?>">Download Brand CSV</a>
                        </div>
                    </div>

                </div>
                <div class="col-7">
                    <div class="import_csv shadow p-3 mb-5 bg-body rounded">
                        <h4>Upload Brand CSV </h4>
                        <?php
                        brand_csv_import_processing();
                        ?>
                        <form id="brand_csv_file_importer" enctype='multipart/form-data' action='' method='post'>
                            <input class="form-control" type='file' name='brand_csv_file'>
                            <input class="form-control mt-4 btn btn-info" type="submit" value="Upload Brand CSV" name="brand_csv_submit_btn">
                        </form>

                    </div>
                </div>

            </div>
        </div>
    </div>
<?php
}
