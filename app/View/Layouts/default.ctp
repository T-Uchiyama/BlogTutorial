<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.View.Layouts
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

$cakeDescription = __d('cake_dev', 'CakePHP: the rapid development php framework');
$cakeVersion = __d('cake_dev', 'CakePHP %s', Configure::version());
?>
<!DOCTYPE html>
  <link href="../../app/webroot/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="../../app/webroot/bootstrap/js/bootstrap.min.js"></script>
<!-- ポップアップ用背景CSSの追加  -->
<style type="text/css">
<!--
    #container
    {
        z-index: 0;
    }

    #back-curtain
    {
        background: rgba(0, 0, 0, 0.5);
        display: none;
        position: fixed;
        left: 0px;
        top: 0px;
        width: 100%;
        height: 120%;
        z-index: 1;
    }

    <!-- 以下スライドショー用  -->
    #slide
    {
        position: relative;
    }

    .defaultImgCls
    {
        margin: 0;
        padding: 10px 10px;
        position: fixed;
        display: none;
        z-index: 2;
    }

    .tempImg
    {
        position: fixed;
    }

    .nav-r
    {
        position: fixed;
        top: 470px;
        left: 1268px;
        padding: 20px 50px;
        font-size: 1.2em;

    }

    .nav-l
    {
        position: fixed;
        top: 470px;
        left: 510px;
        padding: 20px 50px;
        font-size: 1.2em;
    }

-->
</style><html>
<head>
	<?php echo $this->Html->charset(); ?>
	<title>
		<?php echo $cakeDescription; ?>
		<?php echo $this->fetch('title'); ?>
	</title>
	<?php
		echo $this->Html->meta('icon');

		echo $this->Html->css('cake.generic');

		echo $this->fetch('meta');
		echo $this->fetch('css');
		echo $this->fetch('script');
	?>
</head>
<body>
	<div id="container">
		<div id="header">
			<h1><?php
                    if (AuthComponent::user('id') != null) {
                        $username = AuthComponent::user('username');
                        echo "ログイン名 : ", $username;
                    } else {
                        $username = 'Guest';
                      	echo "ログイン名 : ", $username;
                  	}
             	?>
			</h1>
    </div>
		<div id="content">

			<?php echo $this->Flash->render(); ?>

			<?php echo $this->fetch('content'); ?>
		</div>
		<div id="footer">
			<?php echo $this->Html->link(
					$this->Html->image('cake.power.gif', array('alt' => $cakeDescription, 'border' => '0')),
					'http://www.cakephp.org/',
					array('target' => '_blank', 'escape' => false, 'id' => 'cake-powered')
				);
			?>
			<p>
				<?php echo $cakeVersion; ?>
			</p>
		</div>
	</div>
	<?php echo $this->element('sql_dump'); ?>
</body>
</html>
