<div class="container-fluid">

<!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title?></h1>
  
    <div class = "row">
        <div class = "col-lg-6">
        <?= form_error('menu','<div class = "alert alert-danger" role = "alert">', '</div>' );?>
        <?= $this->session->flashdata('message'); ?>
            <a href="" class = "btn btn-primary mb-3" data-toggle="modal" data-target="#newRoleModal">Add New Role</a>
            
            
            
            <table class="table table-hover"> 
                <thead>
                    <tr>
                    <th scope="col">No</th>
                    <th scope="col">Menu</th>
                    <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i = 1;?>
                    <?php foreach($role as $role) :  ?>
                    <tr>
                    <th><?= $i ?></th>
                    <td><?= $role['role']; ?></td>
                    <td>
                        <a href="<?= base_url('admin/roleaccess/') . $role['role_id']; ?>" class = "badge badge-warning">access</a>
                        <a href="" class = "badge badge-success">Edit</a>
                        <a href="" class = "badge badge-danger">Delete</a>
                    </td>
                    </tr>
                    <?php $i++; ?>
                    <?php endforeach; ?>
                
                </tbody>
             </table>
        </div>
    </div>

</div>
<!-- End of Main Content -->

<!-- Modal -->
<div class="modal fade" id="newRoleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="newRoleModalLabel">Add a new role</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
       <form action="<?= base_url('admin/role'); ?>" method = "POST">
            <div class="form-group">
                <input type="text" class="form-control" id="roleName" name = "roleName" placeholder="Menu Name">
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Add</button>
        </div>
      </form>
    </div>
  </div>
</div>