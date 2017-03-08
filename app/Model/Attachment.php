<?php
    class Attachment extends AppModel {
        public $actsAs = array(
            'Upload.Upload' => array(
                'photo' => array(
                    'mimetype' => array(
                        'rule' => array('mimeType', array(
                            'image/jpeg', 'image/png', 'image/gif', 'application/pdf'
                            )
                        ),
                        'message' => array('MIME type error')
                    ),

                    'extension' => array(
                        'rule' => array('extension', array(
                            'jpg', 'jpeg', 'JPG', 'JPEG', 'gif', 'GIF', 'png', 'PNG', 'pdf', 'PDF'
                            )
                        ),
                        'message' => array('file extension error')
                    ),
                ),
             ),
        );

        public $validate = array(
            'photo' => array(
                'filesizeCheck' => array(
                    'rule' => array('isBelowMaxSize', 2097152, false),
                    'message' => 'File is larger than the maximum filesize',
                ),

                'mimetypeCheck' => array(
                    'rule' => array('isValidMimeType', array(
                        'image/jpeg', 'image/png', 'image/gif', 'application/pdf'
                    ), false),
                    'message' => 'File is not a jpeg, png, gif or pdf',
                ),

                'extensionCheck' => array(
                    'rule' => array('isValidExtension', array(
                        'jpg', 'jpeg', 'JPG', 'JPEG', 'gif', 'GIF', 'png', 'PNG', 'pdf', 'PDF'
                    ), false),
                    'message' => 'File does not have a jpg, gif, png or pdf extensions',
                ),

                'writeCheck' => array(
                    'rule' => array('isSuccessfulWrite', false),
                    'message' => 'File was unsuccessfully written to the server'
                ),
            )
        );

        public $belongsTo = array(
            'Post' => array(
                'className' => 'Post',
                'foreignKey' => 'foreign_key',
            ),
            'Comment' => array(
                'className' => 'Comment',
                'foreignKey' => 'foreign_key',
            )
        );

    }
?>
