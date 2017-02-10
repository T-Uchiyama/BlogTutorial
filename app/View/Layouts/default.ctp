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
  <link href="/app/webroot/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="/app/webroot/bootstrap/js/bootstrap.min.js"></script>
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
        echo $this->Html->css('blogModule');

		echo $this->fetch('meta');
		echo $this->fetch('css');
		echo $this->fetch('script');
	?>
</head>
<body>
    <!-- ナビゲーションバー -->
    <nav class="navbar navbar-inverse navbar-fixed-top">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#gnavi">
                <span class="sr-only">メニュー</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a href="/" class="navbar-brand">CakeBlog Menu</a>
        </div>

        <div id="gnavi" class="collapse navbar-collapse">
            <ul class="nav navbar-nav navbar-right">
                <li><a href="/posts">Post</a></li>
                <li><a href="/users">User</a></li>
                <?php
                    if (AuthComponent::user('group_id') == 1)
                    {
                        echo('<li><a href="/categories">Category</a></li>');
                        echo('<li><a href="/tags">Tag</a></li>');
                    }
                ?>

                <?php
                        if (AuthComponent::user('id') != null)
                        {
                            $username = AuthComponent::user('username');
                            echo('<li><a href="#" class="dropdown-toggle"
                                data-toggle="dropdown">ログイン名 : '
                                    .$username. '<b class="caret"></b></a>');
                            echo('<ul class="dropdown-menu">');
                            echo('<li><center><a href="/users/logout">Logout</a></center></li>');
                            echo('</ul>');
                            echo('</li>');
                        } else {
                            $username = 'Guest';
                            echo('<li><a href="#" class="dropdown-toggle"
                                data-toggle="dropdown">ログイン名 : '
                                    .$username. '<b class="caret"></b></a>');
                            echo('<ul class="dropdown-menu">');
                            echo('<li><center><a href="/users/login">Login</a></center></li>');
                            echo('</ul>');
                            echo('</li>');
                        }
                 	?>
            </ul>
        </div>
    </nav>
	<div id="container">
		<div id="header">
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

<script type="text/javascript">

    /* TODO window.resizeをContainerに実施してみたが画面サイズが半分で固定されてしまっている */
    $(document).ready(function ()
    {
        width = $(window).width();
        height = $(window).height();
        $("#container").css("width", width + "px");
        $("#container").css("height", height + "px");
    });

    $(window).resize(function ()
    {
        width = $(window).width();
        height = $(window).height();
        $("#container").css("width", width + "px");
        $("#container").css("height", height + "px");
    });

    $('#zipCord').on('click', '#search_Button', function ()
    {
        // テキストエリアから郵便番号を取得
        var zipNum =  $('#zipText').val();

        // 全角数字を半角数字に変換
        zipNum = zipNum.replace(/[Ａ-Ｚａ-ｚ０-９]/g, function(s)
        {
          return String.fromCharCode(s.charCodeAt(0) - 0xFEE0);
        });

        if (!(zipNum.length > 6 || zipNum.length < 8))
        {
            alert('郵便番号は７桁で入力してください。');
            return;
        }

        $.ajax(
        {
            type: "POST",
            url: "/zips/searchCity",
            data: {'id':zipNum},
            dataType: "json",
            success: function(msg)
            {
                if(msg)
                {
                    $('#zip_pref').prop('disabled', false).val(msg['pref']);
                    $('#zip_city').prop('disabled', false).val(msg['city']);
                    $('#zip_town').prop('disabled', false).val(msg['town']);
                }
            },
            error: function(msg)
            {
                alert('Ajax通信失敗');
            }
        });
    });
</script>
