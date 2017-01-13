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
    foreach ($posts['Attachment'] as $attachment): 
        echo $this->Html->image('../files/attachment/photo/'.$attachment['dir'].'/'.$attachment['photo'],
                    array('alt' => 'baz'));
    endforeach;
 
    echo $this->Form->end('Save Post');
?>

<script type="text/javascript">
    //削除用のJQuery記載の可能性あり
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
