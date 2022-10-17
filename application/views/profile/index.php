<!-- Begin Page Content -->
<div class="container-fluid">

<div class="row">

  <!-- Area Chart -->
  <div class="col-xl-8 col-lg-7">
    <div class="card shadow mb-4">
      <!-- Card Header - Dropdown -->
      <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
        <h6 class="m-0 font-weight-bold text-primary">Profile</h6>
      </div><br>
      <table cellpadding=10 style="margin-left: 34px;">
      <tr>
          <td colspan="3" class="text-center">
                     <!-- FLASH DATA -->    
                    <?php 
                    $dat = $this->session->flashdata('msg');
                        if($dat!=""){ ?>
                                <div id="notifikasi" class="alert alert-success"><strong>Sukses! </strong> <?=$dat;?></div>
                    <?php } ?>  

                    <?php 
                    $dat = $this->session->flashdata('msg2');
                        if($dat!=""){ ?>
                              <div id="notifikasi" class="alert alert-danger"><strong> </strong> <?=$dat;?></div>
                    <?php } ?> 
          </td>
        </tr>
        <tr>
          <td width="200"><h5>Username</h5></td>
          <td width="10"><h5>:</h5></td>
          <td><h5><?= $user['username']; ?></h5></td>
        </tr>
        <tr>
          <td><h5>Level</h5></td>
          <td><h5>:</h5></td>
          <td><h5><?= $user['level']; ?></h5></td>
        </tr>
        <tr>
          <td><h5>Status</h5></td>
          <td><h5>:</h5></td>
          <td><h5>
              <?php if($user['status']==1){
                       echo 'Active';
                    }else{
                        echo 'Not Active';
                    } ?>
          </h5></td>
        </tr>
        <tr>
          <td colspan="3" class="text-center"><br> 
            <a class="btn btn-primary"  href="#modal-password<?= $user['id']; ?>" data-toggle="modal"><span class="fas fa-fw fa-edit"></span>Change Password</a>
          </td>
        </tr>
      </table>
      <br>
    </div>
  </div>
</div>

</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->
    

    <!---------------------------------------------EDIT Data---------------------------------------------->
    <div class="modal fade" id="modal-password<?= $user['id']; ?>">
      <div class="modal-dialog">
    
        <div class="modal-content">
    
          <!-- Modal Header -->
          <div class="modal-header">
            <h4 class="modal-title">Change Password</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
          </div>
    
          <!-- Modal body -->
    
    
          <?php echo form_open('profile/change_password') ?>
    
          <input type="hidden" readonly value="<?= $user['id']; ?>" name="id" class="form-control" >
          <div class="modal-body">
              <div class="form-group">
                  <label for="current_password">Current Password : </label>
                  <input type="password" id="current_password" name="current_password" value="<?= set_value('current_password'); ?>" class="form-control" placeholder="Current Password"  required="">
                  <small class="form-text text-danger"><?= form_error('current_password');?></small>
              </div>

              <div class="form-group">
                  <label for="new_password">New Password : </label>
                  <input type="password" id="new_password" name="new_password1" value="<?= set_value('new_password1'); ?>" class="form-control" placeholder="New Password"  required="">
                  <small class="form-text text-danger"><?= form_error('new_password1');?></small>
                </div>

        
              <div class="form-group">
                  <label for="repeat_password">Repeat Password : </label>
                  <input type="password" id="repeat_password" name="new_password2" value="<?= set_value('new_password2'); ?>" class="form-control" placeholder="Repeat Password"  required="">
                  <small class="form-text text-danger"><?= form_error('new_password2');?></small>
              </div>
    
          </div>
    
          <!-- Modal footer -->
          <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            <input type="submit" name="submit" id="submit" class="btn btn-primary" value="Simpan" />
          </div>
    </form>
        </div>
      </div>
    </div>             
    
    