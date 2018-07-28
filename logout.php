<?php
/**
 * Created by PhpStorm.
 * User: Daniel Bratton
 * Date: 28/06/2018
 * Time: 9:10 PM
 */
session_destroy();
$S_SESSION["Authenticated"] = false;
echo '<script type="text/javascript">',
    '$(document).ready(function(){',
        '$("#successModal").modal("toggle");',
    '});',
'</script>';

?>
<!-- Modal -->
<div id="successModal" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" onclick="gotoHome()">&times;</button>
                <h4 class="modal-title">Log out Successful</h4>
            </div>
            <div class="modal-body">
                <?php
                echo '<p>Good-bye '.$user->getFirstName().'</p>';
                ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" onclick="gotoHome()">Ok</button>
            </div>
        </div>
    </div>
</div>
