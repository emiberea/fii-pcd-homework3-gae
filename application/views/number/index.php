<!-- Begin page content -->
<div class="container">
    <div class="page-header">
        <h2>Enter 2 numbers to get a random value</h2>
    </div>
    <form action="<?php echo base_url(); ?>number" enctype="multipart/form-data" method="post" class="form-inline">
        <input type="number" name="no1" value="<?php if (isset($number_1)) { echo $number_1; } ?>" class="form-control" placeholder="No1">
        <input type="number" name="no2" value="<?php if (isset($number_2)) { echo $number_2; } ?>" class="form-control" placeholder="No2">
        <input type="submit" value="Random" class="btn btn-default">
    </form>
    <br>
    <?php
        if (isset($number_result)) {
            echo '<div class="alert alert-success">The random result is: <b>' . $number_result . '</b></div>';
        }
    ?>
</div>
