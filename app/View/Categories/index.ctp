<!-- File: /app/View/Categories/index.ctp -->

<!--
    ToDo
    現在はUsersのindex.ctpを枠組みとしてコピーのみの状態
    後に記載を変更    
  -->

<h1>Categories List</h1>

<table>
    <tr>
    <th>Id</th>
    <th>Categoryname</th>
    </tr>

 <!-- ここから$categories配列をループさせ投稿記事の情報表示 -->

    <?php foreach ($categories as $category): ?>
        <tr>
        <td>
            <?php
                echo $category['Category']['id'];
            ?>  
        </td>

        <td>
            <?php 
                echo $category['Category']['name'];
            ?>  
        </td>
        </tr>
    <?php endforeach;  ?>  
</table>
