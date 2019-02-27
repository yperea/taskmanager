
<?php
    interface ITaskManager 
    {
        public function create ($description, $userId);
        public function read($id, $userId);
        public function readAll($userId);
        public function update($id, $description, $userId);
        public function delete($id, $userId);
    }
?>