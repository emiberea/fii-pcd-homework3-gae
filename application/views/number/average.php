<!-- Begin page content -->
<div class="container">
    <div class="page-header">
        <h2>Average</h2>
    </div>
    <h4>The numbers are: <?php if (isset($number_array)) { echo implode(', ', $number_array); } else { echo '-'; } ?></h4>
    <h3>The average is: <b><?php if (isset($average)) { echo $average; } else { echo '-'; } ?></b></h3>
</div>
