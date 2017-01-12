<!-- File: /app/View/Posts/add.ctp -->


<h1>Add Post</h1>

<?php
    echo $this->Form->create('Post', array('type' => 'file'));
    echo $this->Form->input('title');
    echo $this->Form->input('body', array('rows' => '3'));
    echo $this->Form->input('category_id', array(
            'label' => 'Category',
            'type' => 'select',
            'options' => $list,
            )
    );
    echo $this->Form->input('Tag', array(
            'label' => 'Tag',
            'type' => 'select',
            'multiple' => 'checkbox',
            'options' => $tag, 
        )
    );

    echo ('<div class="input-group">');
    echo $this->Form->input('image',
                array(
                'div' => false,
                'type' => 'text',
                'id' => 'photoCover',
                'class' => 'form-control',
                'placeholder' => 'select file...'
                )
                    
    ); 
    echo $this->Form->button('ファイル選択', array(
            'div' => false,
            'type' => 'button',
            'id' => 'btn_link',
            'class' => 'btn-info',
        )
    );
    echo ('</div>');    
    
    echo $this->Form->input('Attachment.0.photo', array('type' => 'file', 'label' => 'Image'));
    echo $this->Form->input('Attachment.0.model', array('type' => 'hidden', 'value' => 'Post'));
    echo $this->Form->end('Save Post');
?>

<script>
    $(function () { 
        $(".btn-info#btn_link").click(function () {
            $("#Attachment0Photo").click();
        });         
    });
</script>
