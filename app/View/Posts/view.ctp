<!-- File: /app/View/Posts/view.ctp -->

<h1>
    <?php 
        echo h($post['Post']['title']); 
    ?>
</h1>

<p>
    <small>
        Category: <?php echo $post['Category']['name']?>
    </small>
</p>

<p>
    <small>
        Created: <?php echo $post['Post']['created']?>
    </small>
</p>

<p>
    <?php 
        echo h($post['Post']['body'])
    ?>
</p>

<p>
    <small>
        Tag: <?php foreach($post['Tag'] as $tag): ?>
             <?php echo $tag['title']; ?>
             <?php endforeach; ?>

    </small>
</p>

<p>
    <small>
        <?php
            $base = $this->Html->url('/files/attachment/photo/');
            
            foreach($post['Attachment'] as $attachment):
                echo $this->Html->image( $base . $attachment['dir'] . '/' . $attachment['photo']);
            endforeach;
        ?>
    <small>
</p>
