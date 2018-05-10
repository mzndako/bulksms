<?php
//$array = c()->get_where("class_group","class_group_id", $param3)->row_array();
if(!hAccess("manage_notifications"))
    die("Access Denied");



    d()->where("id", $param1);
    $notification = c()->get('notification')->row_array();

?>
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-primary b-w-0" data-collapsed="0">

                <div class="panel-heading">
                    <div class="panel-title" >
                        <i class="entypo-plus-circled"></i>
                        <?=$notification['title'];?>
                    </div>
                </div>
            </div>
            <div class="panel-body">
<h4>List of Users and Notification Status</h4>
              <table class="table table-bordered">
                  <thead>
                        <tr>
                            <th>#</th>
                            <th>Username</th>
                            <th>Date Viewed</th>
                            <th>Date Read</th>
                        </tr>
                  </thead>
                  <tbody>
                  <?php
                        c()->where("notification_id", $param1);
                        c()->where("view_date > ", 0);
                        $array = c()->get("notification_read")->result_array();

                        $users = get_arrange_id("users", "id");

                        $count = 1;
                        foreach($array as $row) {
                            ?>
                            <tr>
                                <td><?=$count++;?></td>
                                <td><?=c()->get_full_name($row['user_id']);?></td>
                                <td><?=empty($row['view_date'])?"--":convert_to_datetime($row['view_date']);?></td>
                                <td><?=empty($row['read_date'])?"--":convert_to_datetime($row['read_date']);?></td>
                            </tr>
                            <?php
                        }
                  ?>
                  </tbody>
              </table>
            </div>

        </div>


    </div>


