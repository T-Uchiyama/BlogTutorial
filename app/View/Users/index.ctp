<!-- File: /app/View/Users/index.ctp -->

<h1>Users List</h1>

<table>
    <tr>
    <th>Id</th>
    <th>Username</th>
    <th>Role</th>
    <th>Created</th>
    </tr>

 <!-- ここから$users配列をループさせ投稿記事の情報表示 -->

    <?php foreach ($users as $user): ?>
        <tr>
        <td>
            <?php
                echo $user['User']['id'];
            ?>
        </td>

        <td>
            <?php 
                echo $user['User']['username'];
            ?>
        </td>

        <td>
            <?php
                echo $user['User']['role'];
            ?>
        </td>

        <td>
            <?php
                echo $user['User']['created'];
            ?>  
        </td>
        </tr>
    <?php endforeach;  ?>
</table>
