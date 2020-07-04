<div class="container-fluid">

<!-- Page Heading -->
<h1 class="h3 mb-4 text-gray-800"><?= $title?></h1>
<div class = "row">
    <div class = "col-lg-8">
    <?= form_open_multipart('user/edit');?>
            <div class = "form-group row">
                <label for="email" class="col-sm-2 col-form-label">Email</label>
                <div class="col-sm-10">
                    <input type="text" class = "form-control" id= "email" name = "user_email" placeholder = "email" value = "<?= $user['user_email'] ?>" readonly>
                </div>
            </div>
            <div class = "form-group row">
                <label for="name " class="col-sm-2 col-form-label">Name</label>
                <div class="col-sm-10">
                    <input type="text" class = "form-control" id= "name" name = "user_name" placeholder = "name" value = "<?= $user['user_name'] ?>">
                    <?= form_error('user_name', '<small class = "text-danger pl-3">', '</small>');?>
                </div>
            </div>
            <div class = "form-group row">
                <div class = "col-sm-2">Picture</div>
                <div class = "col-sm-10">
                    <div class = "row">
                        <div class = "col-sm-3">
                            <img src="<?= base_url('assets/img/profile/') .$user['user_image'] ;?>" class = "img-thumbnail">
                        </div>
                        <div class = "col-sm-9 ">
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="customFile" name = "user_image">
                                <label class="custom-file-label" for="customFile">Choose file</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class = "form-group row justify-content-end">
                <div class ="col-sm-10">
                    <button type = "submit" class="btn btn-primary">Edit</button>
                </div>
            </div>
        </div>
 
    </form>
</div>

</div>
<!-- End of Main Content -->

