<!-- File: /app/View/Posts/add.ctp -->

<?php
    // パンくずリストの追加
    $this->Html->addCrumb('Home', '/');
    $this->Html->addCrumb('Add', '/posts/add');
    echo $this->Html->getCrumbs(" &rsaquo; ");
?>

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
?>

<?php if (!empty($tagerror)): ?>
    <div class="error-message">
        <?php print_r($tagerror); ?>
    </div>
<?php endif; ?>

<div class="input-group">
    <label><?php echo __('Image'); ?></label>

    <?php for ($i = 0; $i < 3; $i++): ?>
        <div class= "File">
        <?php  
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
        ?>
        </div>
    <?php endfor; ?>
</div>
    
<?php echo $this->Form->end(__('Save Post')); ?>