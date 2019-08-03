<?php
rAccess("manage_phonebook");
?>
<div classs="row">
    <div class="panel">
        <div class="panel-heading">

            <div >
                CONTACTS:<br>
                <input type="text" id="search_keyword" placeholder="Search Contacts" onkeypress="search_contact(this)" onblur="search_contact(this)" style="padding: 3px 5px; color: brown" onkeyup="search_contact()"/>
            </div>
<!--            <i class="fa fa-plus" aria-hidden="true"></i> My Contacts<br>-->
        </div>
<!--        <input type="hidden" name="catch" value="phonebook"/>-->
        <div class="panel-body">
            <div id="mycontacts">
                <?php
                    d()->where("user_id", login_id());
                    $phonebook = c()->get("phonebook")->result_array();
                    foreach($phonebook as $row) {
                        ?>
                        <div class="checkbox checkbox" style="overflow: hidden; white-space: nowrap">
                            <label >
                                <input type="checkbox"/> <?=$row['name'].": ".$row['numbers'];?>
                            </label>
                        </div>
                        <?php
                    }
                ?>
            </div>
            <div align="center">
                <button onclick="import_contacts()" class="btn btn-raised btn-warning">
                    Import Contacts
                </button>
            </div>
        </div>

    </div>
</div>

<script>
    function search_contact(me){
        var v = $("#search_keyword").val().toString().toLowerCase();
        $.each($("#mycontacts").find("[type=checkbox]"), function(){
            var x = $(this).parents(".checkbox").text().trim().toString().toLowerCase();
            if(is_empty(v) || x.indexOf(v) > -1){
                $(this).parents(".checkbox").show(100);
            }else{
                $(this).parents(".checkbox").hide(100)
            }
        });
    }
</script>