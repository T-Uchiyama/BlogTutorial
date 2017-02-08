<!-- File: /app/View/Posts/add.ctp -->


<h1>Add Post</h1>

<?php
    // debug($this->validationErrors);
    // exit;
    echo $this->Form->create('Post', array('type' => 'file'));
    echo $this->Form->input('title');
    echo $this->Form->input('body', array('rows' => '3'));
    echo $this->Form->input('category_id', array(
            'label' => 'Category',
            'type' => 'select',
            'options' => $list,
            'empty' => true,
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

    $i = 0;
    for ($i; $i < 3; $i++) {
        echo ('<div class= "File">');

        echo $this->Form->input('image', array(
                'div' => false,
                'type' => 'text',
                'id' => 'photoCover'.$i,
                'class' => 'form-control',
                'placeholder' => 'select file...',
                'readonly' => true,
            )
        );

        echo $this->Form->button('ファイル選択', array(
                'div' => false,
                'type' => 'button',
                'id' => 'btn_link'.$i,
                'class' => 'btn-info',
                'elementNumber' => $i,
            )
        );
        // TODO 画像用のバリデーションエラー出力に成功したが記載方法かスマートかが不明･･･
        if (isset($validationError[$i]))
        {
            echo $validationError[$i]['photo'][0];
        }
        // if ($this->Form->isFieldError('Attachment'.$i.'photo'))
        // {
        //     echo $this->Form->error('Attachment'.$i.'photo');
        // }
        echo $this->Form->input('Attachment'.$i.'photo', array(
                'type' => 'file',
                'label' => false,
                'id' => 'Attachment'.$i.'Photo',
                'name' => 'data[Attachment]['.$i.'][photo]',
                'style' => 'display:none',
                )
        );

        echo $this->Form->input('Attachment'.$i.'model', array(
                 'type' => 'hidden',
                 'id' => 'Attachment'.$i.'Model',
                 'name' => 'data[Attachment]['.$i.'][model]',
                 'value' => 'Post',
                )
        );

        echo ('</div>');
    }

    echo ('</div>');

    echo $this->Form->end('Save Post');
?>

<script type="text/javascript">
    $(function () {
        $("[id^=btn_link]").on(
        {
            'click' : function()
            {
                var id = $(this).attr('id');
                var columnNum = document.getElementById(id).getAttribute('elementNumber');
                $('#Attachment' + columnNum  + 'Photo').click();

                $('#Attachment' + columnNum  + 'Photo').change(function() {
                    if ($('#photoCover' + columnNum).attr('placeholder') != null)
                    {
                        //placeHolderの削除
                        $('#photoCover' + columnNum).removeAttr('placeholder');
                        //TextAreaに名称表示
                        $('#photoCover' + columnNum).val($(this).val().replace("C:\\fakepath\\", ""));
                    }
                });
            }
        });
    });
</script>
