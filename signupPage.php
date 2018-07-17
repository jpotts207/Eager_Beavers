<?php
/**
 * Created by PhpStorm.
 * User: Daniel Bratton
 * Date: 3/07/2018
 * Time: 6:58 PM
 */
?>
<div class="jumbotron">
    <h1>Sign Up</h1>
    <h2>To Be Implemented</h2>
</div>
<div id="container" class="row-md-2 form-group">
    <form action="signup.php" method="post" >
        <div class="form-group">
            <fieldset name ="signup">
                <table class="table-borderless" align="center">
                    <tr>
                        <td>
                            <div class="col-*-*">
                                <label for="name">email : </label>
                                <input class="form-control" id="email" name="email" placeholder="email" type="email" required>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="col-*-*">
                                <label for="name">First Name : </label>
                                <input class="form-control" id="name" name="name" placeholder="name" type="text" required>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="col-*-*">
                                <label for="name">Last Name : </label>
                                <input class="form-control" id="surname" name="surname" placeholder="surname" type="text" required>
                            </div>
                        </td>
                    </tr>
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
</div>