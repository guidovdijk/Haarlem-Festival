<?php
include '../classes/autoloader.php';
class danceIntroService
{
    public function __construct()
    {
        $this->db = database::getInstance();
        $this->conn = $this->db->getConnection();
    }

    public function getHeaderInfo()
    {
        $query = "SELECT * FROM Pages WHERE page_id = 2";
        $result = $this->conn->query($query);

        if($result)
            {
                while($row = $result->fetch_assoc())
                {
                    $info = json_decode($row["content"]);
                    return new jazzIntro($info->title, $info->image);
                }
            }
    }
}
?>