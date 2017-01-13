<!-- File: /app/View/Posts/edit.ctp -->

<h1>Edit Post</h1>
<?php
    echo $this->Form->create('Post', array('type' => 'file'));
    echo $this->Form->input('title');
    echo $this->Form->input('body', array('rows' => 3));
    echo $this->Form->input('id', array('type' => 'hidden'));
    echo $this->Form->input('category_id', array(
            'label' => 'Category',
            'type' => 'select',
            'options' => $list
            )
    );
    echo $this->Form->input('Tag', array(
            'label' => 'Tag',
            'type' => 'select',
            'multiple' => 'checkbox',
            'options' => $tag
            )
    );
    
    echo ('<div class="input-group">');
    echo $this->Form->input('image', array(
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
    
    echo $this->Form->input('Attachment.0.photo', array(
            'type' => 'file', 
            'label' => false,
            'style' => 'display:none',
            )
    );

    echo $this->Form->input('Attachment.0.model', array('type' => 'hidden', 'value' => 'Post'));
    echo $this->Form->end('Save Post');
?>

<script type="text/javascript">
    $(function () { 
        $(".btn-info#btn_link").on( 
        {
            'click' : function()
            {
                $("#Attachment0Photo").click();
                
                $('#Attachment0Photo').change(function() {
                    //placeHolderの削除
                    $('.form-control#photoCover').removeAttr('placeholder');
                    //TextAreaに名称表示
                    $('#photoCover').val($(this).val().replace("C:\\fakepath\\", ""));
                });
            }
        });         
    });
</script>
