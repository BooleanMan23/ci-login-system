<div class="container-fluid">

<!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title?></h1>
  
    <div class = "row">
        <div class = "col-lg-6">
        <?= $this->session->flashdata('message'); ?>
        <h5>Role : <?= $role['role'] ?></h5>
            <table class="table table-hover"> 
                <thead>
                    <tr>
                    <th scope="col">No</th>
                    <th scope="col">Menu</th>
                    <th scope="col">Access</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i = 1;?>
                    <?php foreach($menu as $menu) :  ?>
                    <tr>
                    <th><?= $i ?></th>
                    <td><?= $menu['menu']; ?></td>
                    <td>
                         <div class="form-check">
                            <input class="form-check-input" type="checkbox" <?= check_access($role['role_id'], $menu['id']); ?> >
                        </div>  
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

