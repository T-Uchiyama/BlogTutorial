<!-- File: /app/View/tags/index.ctp -->

<h1>Tags List</h1>

<table>
    <tr>
    <th>Id</th>
    <th>Tagname</th>
    </tr>

 <!-- ここから$tag配列をループさせ投稿記事の情報表示 -->

    <?php foreach ($tags as $tag): ?>
        <tr>
        <td>
            <?php
                echo $tag['Tag']['id'];
            ?>
        </td>

        <td>
            <?php 
                echo $tag['Tag']['title'];
            ?>
        </td>
        </tr>
    <?php endforeach;  ?>
</table>
