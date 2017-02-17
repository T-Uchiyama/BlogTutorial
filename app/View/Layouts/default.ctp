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

$cakeDescription = __d('cake_dev', 'CakeBlogMenu');
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
                <li><a href="/posts"><?php echo __('Post') ?></a></li>
                <li><a href="/users"><?php echo __('User') ?></a></li>
                <?php
                    if (AuthComponent::user('group_id') == 1)
                    {
                        echo ('<li><a href="/categories">');
                        echo __('Category');
                        echo ('</a></li>');
                        echo ('<li><a href="/tags">');
                        echo __('Tag');
                        echo ('</a></li>');
                    }
                ?>

                <?php
                        /*
                         * TODO : dropdown-menuの表示でdividerか何かを後に追加あるかも
                         */
                        if (AuthComponent::user('id') != null)
                        {
                            $username = AuthComponent::user('username');
                            echo ('<li><a href="#" class="dropdown-toggle"
                                data-toggle="dropdown">');
                            echo __('LoginName : ');
                            echo ($username. '<b class="caret"></b></a>');
                            echo ('<ul class="dropdown-menu">');
                            echo ('<li><center><a href="/users/logout">');
                            echo __('Logout');
                            echo ('</a></center></li>');
                            echo ('<li><center><a href="/users/password/' . AuthComponent::user('id') .'"> ');
                            echo __('Password');
                            echo ('</a></center></li>');
                            echo ('</div>');
                            echo ('</ul>');
                            echo ('</li>');
                        } else {
                            $username = 'Guest';
                            echo ('<li><a href="#" class="dropdown-toggle"
                                data-toggle="dropdown">');
                            echo __('LoginName : ');
                            echo ($username. '<b class="caret"></b></a>');
                            echo ('<ul class="dropdown-menu">');
                            echo ('<li><center><a href="/users/login">');
                            echo __('Login');
                            echo ('</a></center></li>');
                            echo ('</ul>');
                            echo ('</li>');
                        }
                        echo ('</div>')
                 	?>
            </ul>
        </div>
    </nav>
	<div id="container">
		<div id="header">
        </div>

		<div id="content">
            <?php
                echo $this->Session->flash();
                echo $this->Session->flash('auth');
            ?>
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

	<!-- <?php echo $this->element('sql_dump'); ?> -->
</body>
</html>

<script type="text/javascript">

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

    $('#contact_form').on('click', '#send_Button', function()
    {
        var sender = $('#mail_name').val();
        var content = $('#mail_content').val();

        if (sender == '' || content == '')
        {
            alert('名前か本文に不備が存在します。');
            return;
        }

        alert('メール送信を実施します。');

        $.ajax({
            url: '/posts/send',
            type: 'POST',
            dataType: 'json',
            data: {'name': sender, 'mailBody' : content},
        })
        .done(function(e) {
            alert(e);
        })
        .fail(function(e) {
            alert(e);
        })
        .always(function(e) {
            console.log("Ajax is finished");
        });


    });
</script>
