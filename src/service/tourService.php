<?php 
include '../classes/autoloader.php';

class tourService {

    public function __construct() {
        $this->db = database::getInstance();
        $this->conn = $this->db->getConnection();
    }

    public function getAllTours()
    {
        $query = "SELECT * FROM Tours";
        $result = $this->conn->query($query);

        if($result)
        {
            $tours = array();

            while($row = $result->fetch_assoc())
            {
                $tour = new tour(
                    $row["tour_id"],
                    $row["date"],
                    $row["time"],
                    (float)$row["price"],
                    (float)$row["family_price"],
                    (int)$row["seats_per_tour"]
                );

                $tours[] = $tour;
            }
            return $tours;
        }
    }

    public function getTourById(int $id)
    {
        $query = "SELECT * FROM Tours WHERE tour_id='$id'";
        $result = $this->conn->query($query);

        if($result)
        {
            while($row = $result->fetch_assoc())
            {
                $tour = new tour(
                    $row["tour_id"],
                    $row["date"],
                    $row["time"],
                    (float)$row["price"],
                    (float)$row["family_price"],
                    (int)$row["seats_per_tour"],
                    $this->getTourTypes($row["tour_id"])
                );

                return $tour;
            }
        }
    }

    /**
     * getTourTypes - Amount of tours and the language of a specific tour
     * 
     * @param int $id - id of the specific tour
     * @return array<tourTypes> - array of amount and language of the tours
     */
    public function getTourTypes(int $id) : array
    {
        $query = "SELECT * FROM Tour_Types WHERE tour_id=?";

        if($stmt =  $this->conn->prepare($query)) {
            // Create bind params to prevent sql injection
            $stmt->bind_param("i", $id);

            // Execute query
            $stmt->execute();

            // Get the result
            $result = $stmt->get_result();

            $tourTypesArray = array();
            while($row = $result->fetch_assoc())
            {
                $tourType = new tourType(
                    (int)$row["tour_id"],
                    (int)$row["tour_types_id"],
                    (int)$row["tour_guide_id"],
                    $row["amount_of_tours"],
                    $row["language"]
                );

                $tourTypesArray[] = $tourType;
            }

            return $tourTypesArray;
        }
    }
}
?>