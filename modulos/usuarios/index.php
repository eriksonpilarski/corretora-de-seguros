<?php
require "../../class/App.php";
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
                border: 1px solid #767676;
                padding-top: 30px;
                box-shadow: 4px 4px 4px #767676;
                margin-top: 10%;
            }
            .btn {
                margin-left: 18%;
            }            
        </style>
    </head>
    <body>
        <div class="container">
            <div class="row">
                <div class="span8 offset1 login">
                    <form class="form-horizontal" action="#" method="post">
                        <div class="control-group">
                            <label class="control-label" for="login"></label>
                            <div class="controls">
                                <input type="text" id="login" name="login" placeholder="usuario"  />
                                <span class="help-inline">Requerido</span>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label" for="pass"></label>
                            <div class="controls">
                                <input type="password" id="pass" name="pass" placeholder="senha"  />
                                <span class="help-inline">Requerido</span>
                            </div>
                        </div>
                        <div class="control-group">
                            <div class="controls">
                                <button type="submit" class="btn">Login</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <script type="text/javascript" src="<?php echo App::getAppPath(); ?>js/jquery1.8.3.min.js"></script>
        <script type="text/javascript" src="<?php echo App::getAppPath(); ?>js/bootstrap.min.js"></script>
        <script type="text/javascript" src="index.js"></script>
    </body>
</html>