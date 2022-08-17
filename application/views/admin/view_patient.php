
<!-- modal -->
<!-- Button trigger modal -->
<!-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalLong">
  Launch demo modal
</button> -->

<!-- Modal -->
<div class="modal fade" id="exampleModalLong" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <div class="d-flex align-items-center">
            <div class="img_random"><img src="" style="width: 50px; height: 50px; border-radius: 50%;" id = "patient_profile_image" ></div>
            <h5 class="modal-title" id="exampleModalLongTitle"></h5>
        </div>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="new_apponment">
            <table id="table_id" class="display responsive nowrap common_table" style="width:100%">
               <tbody>
                   <tr>
                       <td>Email</td>
                       <td id="email"></td>
                   </tr>
                   <tr>
                       <td>Mobile</td>
                       <td id="mobile"></td>
                   </tr>
                   <tr>
                       <td>Age</td>
                       <td id="age"></td>
                   </tr>
                   <tr>
                       <td>Gender</td>
                       <td id="gender"></td>
                   </tr>
                   <tr>
                       <td>Status</td>
                       <td id="status"></td>
                   </tr>
               </tbody>
           </table>
       </div>
      </div>
      <div class="modal-footer">
       <!--  <button type="button" class="btn btn-secondary" data-dismiss="modal"></button> -->
        <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>