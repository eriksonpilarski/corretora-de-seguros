<?php

require "../../class/App.php";

if( ! isset($_SESSION['id-usuario'])  ) header("Location: ".App::getAppPath()."modulos/usuarios/")
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>SEG</title>
        <link href="<?php echo App::getAppPath(); ?>css/bootstrap.min.css" rel="stylesheet" media="screen" />
        <style type="text/css" media="all">
            div.login {
                border-radius: 5px 5px 5px 5px;
                box-shadow: 5px 5px 20px #767676;
                margin-top: 10%;
                padding-top: 30px;
            }
            .btn {
                margin-left: 18%;
            }
            .form-horizontal .controls {
                margin-left: 50px;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="row">
                <div class="span6 offset1 login">
                    <form class="form-horizontal" action="#" method="post">
                        <div class="control-group">
                            <div class="controls">
                                <input type="text" id="login" name="login" placeholder="usuario"  />
                                <span class="help-inline" style="display: none">Requerido</span>
                            </div>
                        </div>
                        <div class="control-group">
                            <div class="controls">
                                <input type="password" id="pass" name="pass" placeholder="senha"  />
                                <span class="help-inline" style="display: none">Requerido</span>
                            </div>
                        </div>
                        <div class="control-group">
                            <div class="controls">
                                <button type="submit" class="btn">Login</button>
                            </div>
                        </div>
                    </form>

                    <div class="alert alert-error" style="display:none" >
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                        <strong>Ops. - </strong><span id="msg"></span>
                    </div>

                </div>
            </div>
        </div>
        <script type="text/javascript" src="<?php echo App::getAppPath(); ?>js/jquery1.8.3.min.js"></script>
        <script type="text/javascript" src="<?php echo App::getAppPath(); ?>js/bootstrap.min.js"></script>
        <script type="text/javascript" src="index.js"></script>
    </body>
</html>