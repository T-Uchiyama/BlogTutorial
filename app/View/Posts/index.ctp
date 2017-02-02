<!-- File: /app/View/Posts/index.ctp -->

<h1>Blog posts</h1>
<?php
    echo $this->Form->Create('Post', array(
            'url' => array_merge(array(
                'action' => 'index'
                ), $this->params['pass']
            )
        )
    );
?>
<fieldset>
    <div id="searchFuncPush">
        <legend>検索</legend>
    </div>

    <div id="searchLink">
        <!-- Category  -->
        <?php
            echo $this->Form->input('category_id', array(
            'label' => 'カテゴリ',
            'id' => 'search_category',
            'class' => 'category',
            'empty' => true,
            )
        );
    ?>
    <!-- Tag  -->
    <?php
        echo $this->Form->input('tag_id', array(
            'label' => 'タグ',
            'type' => 'select',
            'multiple' => 'checkbox',
            'options' => $tags,
            // 'id' => 'search_tag',
            // 'class' => 'tag',
            // 'empty' => true,
            )
        );
    ?>
    <!-- Title  -->
    <?php
        echo $this->Form->input('title', array(
            'label' => 'タイトル',
            'type' => 'text',
            'id' => 'search_title',
            'class' => 'title',
            'empty' => true,
            'placeholder' => 'キーワードを入力してください。',
            )
        );
    ?>

    <?php
        echo $this->Form->Submit('検索');
    ?>
    </div>
<?php
    echo $this->Form->End();
?>
</fieldset>

<div id="zipCord">
<?php
    // 郵便番号検索用
    echo $this->Form->input('郵便番号', array(
        'type' => 'text',
        'id' => 'zipText',
        'placeholder' => '郵便番号を入力してください。'
        )
    );

    echo $this->Form->button('検索', array(
        'type' => 'button',
        'id' => 'search_Button',
        )
    );

    echo $this->Form->input('都道府県', array(
        'type' => 'text',
        'id' => 'zip_pref',
        )
    );

    echo $this->Form->input('市区町村', array(
        'type' => 'text',
        'id' => 'zip_city',
        )
    );

    echo $this->Form->input('町域', array(
        'type' => 'text',
        'id' => 'zip_town',
        )
    );
?>

</div>

<?php
    echo $this->Html->link(
        'Add Post',
        array ('controller' => 'posts', 'action' => 'add'));
 ?>

<table>
    <tr>
	<th>Id</th>
	<th>Title</th>
	<th>Action</th>
	<th>Created</th>
    <th>Category</th>
    <tr>

    <!-- ここから$posts配列をループさせ投稿記事の情報表示 -->

    <?php foreach ($posts as $post): ?>
    <tr>
	<td>
	    <?php
	      echo $post['Post']['id'];
            ?>
	</td>

	<td>
	    <?php
              echo $this->Html->link(
      		  $post['Post']['title'],
	          array('action' => 'view', $post['Post']['id']));
	    ?>
	</td>

    <td>
        <?php
            if ($post['Post']['user_id'] == AuthComponent::user('id')
                || AuthComponent::user('group_id') == 1):

                echo $this->Form->postLink(
    		    'Delete',
                array('action' => 'delete', $post['Post']['id']),
                array('confirm' => 'Are you sure?')
    	        );
                echo('&nbsp&nbsp');
                echo $this->Html->link(
    		    'Edit',
    		    array('action' => 'edit', $post['Post']['id']));
            endif;
    ?>
	</td>

    <td>
	    <?php
            echo $post['Post']['created'];
	    ?>
	</td>

    <td>
        <?php
            echo $post['Category']['name'];
        ?>
    </td>
    </tr>
    <?php endforeach; ?>

</table>
<?php
    if ($this->Paginator->hasPrev())
    {
        echo $this->Paginator->prev(
            '< 前へ  ',
            array(),
            null,
            array('class' => 'prev disabled')
        );
    }

    echo $this->Paginator->numbers(
        array(
            'separator' => '  '
        )
    );
    if ($this->Paginator->hasNext())
    {
        echo $this->Paginator->next(
            '  次へ >',
            array(),
            null,
            array('class' => 'next disabled')
        );
    }
?>
<script>
    $(function ()
    {
        // 検索エリアの非表示
        $('#searchLink').css('display', 'none');

        // div要素をクリックされたら切り替えの実施
        $('#searchFuncPush').click(function()
        {
            $('#searchLink').toggle();
        });
    });

    $('#zipCord').on('click', '#search_Button', function ()
    {
        // テキストエリアから郵便番号を取得
        var zipNum =  $('#zipText').val();

        $.ajax({
            type: "POST",
            url: "/zips/searchCity",
            data: {'id':zipNum},
            dataType: "json",
            success: function(msg)
            {
                if(msg)
                {
                    $('#zip_pref').val(msg['pref']);
                    $('#zip_city').val(msg['city']);
                    $('#zip_town').val(msg['town']);
                }
            },
            error: function(msg)
            {
                alert('Ajax通信失敗');
            }
        });
    });

</script>
