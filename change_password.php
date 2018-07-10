<?php
/**
 * Created by PhpStorm.
 * User: Daniel Bratton
 * Date: 10/07/2018
 * Time: 6:48 PM
 */

$temp_user = false;
if(isset($_SESSION["temp_user"])){
    $temp_user = true;
}
else
?>
<div id="container" class="row-md-2 form-group">
    <h1>Reset Password</h1>
    <form action="password_change.php" method="post" >
        <div class="form-group">
            <fieldset name ="CHANGE">
                <table class="table-borderless" align="center">
                    <tr>
                        <td>
                            <div class="col-*-*">
                                <label for="password">Password : </label>
                                <input class="form-control" id="password" name="password" placeholder="********" type="password" required>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="col-*-*">
                                <label for="password">Confirm Password: </label>
                                <input class="form-control" id="confirm_password" name="confirm_password" placeholder="" type="password" required oninput="checkPasswordsMatch(this)">
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="btn-group btn-group-md">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </td>
                    </tr>
                </table>
            </fieldset>
        </div>
    </form>
