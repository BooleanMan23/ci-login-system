<div class="container-fluid">

<!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title?></h1>
  
    <div class = "row">
        <div class = "col-lg-10">
        <?php if(validation_errors()) : ?>
            <div class = "alert alert-danger" role = "alert">
                 <?= validation_errors();?>
            </div> 
        <?php endif; ?>
        <?= $this->session->flashdata('message'); ?>
            <a href="" class = "btn btn-primary mb-3" data-toggle="modal" data-target="#newMenuModal">Add New Submenu</a>
            <table class="table table-hover">
                <thead>
                    <tr>
                    <th scope="col">No</th>
                    <th scope="col">Title</th>
                    <th scope="col">Menu</th>
                    <th scope="col">Url</th>
                    <th scope="col">Icon</th>
                    <th scope="col">Active</th>
                    <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                <?php $i = 1;?>
                    <?php foreach($submenu as $submenu) :  ?>
                    <tr>
                    <th><?= $i ?></th>
                    <td><?= $submenu['title']; ?></td>
                    <td><?= $submenu['menu']; ?></td>
                    <td><?= $submenu['url']; ?></td>
                    <td><?= $submenu['icon']; ?></td>
                    <td><?= $submenu['is_active']; ?></td>
                    <td>
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
<div class="modal fade" id="newMenuModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="newMenuModalLabel">Add a new Submenu</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
       <form action="<?= base_url('menu/submenu'); ?>" method = "POST">
            <div class="form-group">
                <input type="text" class="form-control" id="title" name = "title"  placeholder="Submenu title">
            </div>
            <div class="form-group">
                <select name="menu_id" id="menu_id" class = "form-control">
                    <option value="">Select Menu</option>
                    <?php foreach($menu as $menu) :  ?>
                    <option value="<?= $menu['id'] ?>"><?= $menu['menu'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <input type="text" class="form-control" id="url" name = "url"  placeholder="Submenu url">
            </div>
            <div class="form-group">
                <input type="text" class="form-control" id="icon" name = "icon"  placeholder="Submenu icon">
            </div>
            <div class="form-group">
                <div class = "form-check">
                    <input type="checkbox" class="form-check-input" name = "is_active" id="is_active" value = "1" checked>
                    <label for="is_active" class = "form-check-label">Active?</label>           
                </div>
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