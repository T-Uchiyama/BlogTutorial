<!-- File: /app/View/Posts/add.ctp -->

<h1 class="heading_add"><?php echo __('Add Post'); ?></h1>

<?php
    echo $this->Form->create('Post', array('type' => 'file'));
    echo $this->Form->input('title', array(
            'label' => __('Title'),
            'required' => false,
        )
    );
    echo $this->Form->input('body', array(
            'rows' => 3,
            'label' => __('Body'),
            'required' => false,
        )
    );
    echo $this->Form->input('category_id', array(
            'label' => __('Category'),
            'type' => 'select',
            'options' => $list,
            'empty' => true,
            'required' => false,
            )
    );
    echo $this->Form->input('Post.Tag', array(
            'label' => __('Tag'),
            'type' => 'select',
            'multiple' => 'checkbox',
            'options' => $tag,
            'required' => false,
        )
    );
    if(!empty ($tagerror))
    {
        echo ('<div class="error-message">');
        print_r($tagerror);
        echo ('</div>');
    }

    echo ('<div class="input-group">');

    echo('<label>');
    echo __('Image');
    echo('</label>');
    for ($i = 0; $i < 3; $i++) {
        echo ('<div class= "File">');

        echo $this->Form->input('image', array(
                'label' => false,
                'div' => false,
                'type' => 'text',
                'id' => 'photoCover'.$i,
                'class' => 'form-control',
                'placeholder' => 'select file...',
                'readonly' => true,
                // requiredをfalseに
            )
        );

        echo $this->Form->button(__('Choice File'), array(
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

    echo $this->Form->end(__('Save Post'));
?>

<script type="text/javascript">
    $(function ()
    {
        var id;
        var columnNum;

        $("[id^=btn_link]").on(
        {
            'click' : function()
            {
                id = $(this).attr('id');
                columnNum = document.getElementById(id).getAttribute('elementNumber');
                $('#Attachment' + columnNum  + 'Photo').click();

                $('#Attachment' + columnNum  + 'Photo').change(function()
                {
                    // placeHolderが何も選択されていない状態かで判別
                    if ($('#photoCover' + columnNum).attr('placeholder') == 'select file...')
                    {
                        //TextAreaに名称表示
                        $('#photoCover' + columnNum).val($(this).val().replace("C:\\fakepath\\", ""));

                    } else {
                        if ($(this).val())
                        {
                            // 名称を上書きし、TextAreaに名称表示
                            $('#photoCover' + columnNum).val($(this).val().replace("C:\\fakepath\\", ""));
                        } 
                    }
                });
            },

        });
    });
</script>
