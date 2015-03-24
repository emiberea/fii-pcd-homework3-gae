<!-- Begin page content -->
<div class="container">
    <div class="page-header">
        <h2>Upload file form</h2>
    </div>
    <form action="<?php echo $upload_url; ?>" enctype="multipart/form-data" method="post">
        Files to upload: <br>
        <input type="file" name="uploaded_files" size="40">
        <input type="submit" value="Send" class="btn btn-default">
    </form>
</div>
