<?php
    App::uses('PostviewlogsController', 'Controller');

    class PostviewlogsShell extends AppShell
    {
        public function startup()
        {
            parent::startup();
            $this->PostviewlogsController = new PostviewlogsController();
        }

        public function callShell()
        {
            $this->out($this->PostviewlogsController->callShell());
        }
    }
?>
