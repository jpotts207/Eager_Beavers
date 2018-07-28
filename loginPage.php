<?php
/**
 * Created by PhpStorm.
 * User: Tapra/Daniel Bratton
 * Date: 26/6/18
 * Time: 12:20
 */

?>
    <div class="panel panel-default">
        <div class="panel-body beaver">
            <h1>Log in</h1>
        </div>
    </div>
    <div id="container">
        <div class="beaverLogin">
        <form action="login.php" method="post" >
            <div class="form-group">
            <fieldset name ="LOGIN">
                <table class="table-borderless" align="center">
                    <tr>
                        <td>
                            <div class="col-*-*">
                                <label for="name">Username : </label>
                                <input class="form-control" id="name" name="username" placeholder="username" type="email" required>
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
                            <div class="btn-group btn-group-md">
                                <button type="submit" class="btn btn-primary">login</button>
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#resetModal">Reset Password</button>
                            </div>
                        </td>
                    </tr>
                </table>
            </fieldset>
            </div>
        </form>
        </div>
    </div>

<!-- Modal requesting input from user (email)-->
<div id="resetModal" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Enter your email</h4>
            </div>
            <div class="modal-body">
                <form action="reset.php" method="post">
                    <div>
                        <fieldset>
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
                                    <div class="btn-group btn-group-md">
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                    </div>
                                </td>
                            </tr>
                        </fieldset>
                    </div>
                </form>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>

    </div>
</div>

