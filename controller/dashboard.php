<?php
    // include('../config/db.php');


    function  GetLocationList() 
    {
        global $connL;

        $cmd = $connL->prepare(@"SELECT location FROM dbo.mf_location ORDER BY location");
        $cmd->execute();

        $locationListArr = [];

        while ($r = $cmd->fetch(PDO::FETCH_ASSOC))
        {
            $locationListArr[] = array( 'code' => $r['location'] ,'desc' => $r['location'] );
        }

        echo json_encode($locationListArr);
    }

    function GetColor(){

        $rgbColor = array();

        foreach(array('r', 'g', 'b') as $color){
            $rgbColor[$color] = mt_rand(0, 255);
        }

        $colors = implode(",", $rgbColor);

        $rgba = 'rgba('.$colors.',0.7)';

        return $rgba;

    }

    function GetPopulation($location){

        global $connL;

        // var_dump(isset($location) && empty($location));

        if(isset($location) && empty($location)){

            $query = 'SELECT DISTINCT(location), COUNT(location) OVER (PARTITION BY location) AS population FROM employee_profile ORDER BY location';
            $stmt =$connL->prepare($query);
            $stmt->execute();

        }else{

            $query = 'SELECT DISTINCT(location), COUNT(location) OVER (PARTITION BY location) AS population FROM employee_profile WHERE location = :location ORDER BY location';
            $stmt =$connL->prepare($query);
            $param = array(":location"=> $location);
            $stmt->execute($param);

        }

        $result = $stmt->fetch();

        $labels = array();
        $data = array();
        $backgroundColor = array();

        if($result){
            do {
                $labels[] = $result['location'];
                $data[] = $result['population'];
            } while ($result = $stmt->fetch());
        }

        for($x = 0; $x< count($data); $x++){
            array_push($backgroundColor, GetColor());
        }

        $datasets = array('label' => "",'data' => $data,'backgroundColor' => $backgroundColor,'borderColor'=>'#ffffff','borderWidth'=>1);
        $data = array('labels' => $labels, 'datasets' => array($datasets));

        echo json_encode($data);
    }

    function GetAgeCount($location){
        
        global $connL;

        if(isset($location) && empty($location)){

            $query = '
                WITH cte_employeeage AS
                (
                    SELECT DISTINCT(label), agecount FROM employeeage WHERE label IS NOT NULL
                )
                SELECT DISTINCT(label), SUM(agecount) OVER (PARTITION BY label) agecount FROM cte_employeeage';
            $stmt =$connL->prepare($query);
            $stmt->execute();

        }else{
            
            $query = 'SELECT DISTINCT(location),agecount,label FROM employeeage WHERE location = :location AND label IS NOT NULL ORDER BY label';
            $stmt =$connL->prepare($query);
            $param = array(":location"=> $location);
            $stmt->execute($param);

        }

        // $query = 'SELECT DISTINCT(label), COUNT(age) OVER (PARTITION BY label) agecount  FROM dbo.employeeage ORDER BY label';
        // $query = 'SELECT age, COUNT(age) agecount, label FROM dbo.employeeage WHERE label IS NOT NULL GROUP BY age, label ORDER BY age, label';
        // $query = 'SELECT DISTINCT(location),agecount,label FROM employeeage WHERE location = :location AND label IS NOT NULL ORDER BY label';
        // $stmt =$connL->prepare($query);
        // $param = array(":location"=> $location);
        // $stmt->execute($param);

        $result = $stmt->fetch();

        $labels = array();
        $data = array();
        $pointBackgroundColor = array();

        // $data2025 = array();
        // $data2630 = array();
        // $data3135 = array();
        // $data3640 = array();
        // $data4145 = array();
        // $data45UP = array();

        $datasets = array();

        if($result){
            do {
                $data[] = $result['agecount'];
                $labels[] = $result['label'];

                // switch($result['label']){
                //     case '20 - 25':
                //         $data2025[] = $result['agecount'];
                //     break;
                //     case '26 - 30':
                //         $data2630[] = $result['agecount'];
                //     break;
                //     case '31 - 35':
                //         $data3135[] = $result['agecount'];
                //     break;
                //     case '36 - 40':
                //         $data3640[] = $result['agecount'];
                //     break;
                //     case '41 - 45':
                //         $data4145[] = $result['agecount'];
                //     break;
                //     case '45 - UP':
                //         $data45UP[] = $result['agecount'];
                //     break;
                // }
            } while ($result = $stmt->fetch());
        }

        for($x = 0; $x< count($labels); $x++){
            // array_push($pointBackgroundColor, GetColor());
            $pointBackgroundColor[] = GetColor();
        }

        // array_push($labels, '20 - 25', '26 - 30', '31 - 35', '36 - 40', '41 - 45', '45 - UP');

        // array_push($datasets,
        // array('data'=> $data2025, 'label'=> '20 - 25','borderColor'=> '#3e95cd','fill'=> 'false'),
        // array('data'=> $data2630, 'label'=> '26 - 30','borderColor'=> '#8e5ea2','fill'=> 'false'),
        // array('data'=> $data3640, 'label'=> '31 - 35','borderColor'=> '#8e5ea2','fill'=> 'false'),
        // array('data'=> $data4145, 'label'=> '36 - 40','borderColor'=> '#8e5ea2','fill'=> 'false'),
        // array('data'=> $data45UP, 'label'=> '41 - 45','borderColor'=> '#3cba9f','fill'=> 'false'));
        // $data = array('labels'=>$labels, 'datasets'=> $datasets);

        $datasets = array('label' => "",'data' => $data,'borderColor'=>'rgba(142, 94, 162, 0.7)','fill'=> 'false','borderWidth'=>1);
        $data = array('labels' => $labels, 'datasets' => array($datasets));

        echo json_encode($data);
    }

    function GetGenderCount($location){

        global $connL;

        if(isset($location) && empty($location)){

            $query = 'SELECT sex, COUNT(sex) gendercount FROM employee_profile GROUP BY sex ORDER BY sex';
            $stmt =$connL->prepare($query);
            $stmt->execute();

        }else{

            $query = 'SELECT sex, COUNT(sex) gendercount FROM employee_profile WHERE location = :location GROUP BY sex ORDER BY sex';
            $stmt =$connL->prepare($query);
            $param = array(":location"=> $location);
            $stmt->execute($param);

        }

        $result = $stmt->fetch();

        $labels = array();
        $data = array();
        $backgroundColor = array();

        if($result){
            do {
                $labels[] = $result['sex'];
                $data[] = $result['gendercount'];
            } while ($result = $stmt->fetch());
        }

        array_push($backgroundColor, 'rgba(242, 136, 168, 0.7)', 'rgba(66, 117, 245, 0.7)');

        $datasets = array('label' => "",'data' => $data,'backgroundColor' => $backgroundColor ,'borderColor' =>'#ffffff','borderWidth'=>1);
        $data = array('labels'=>$labels, 'datasets'=> array($datasets));

        echo json_encode($data);
    }

?>