<?php

    class DropDown
    {
        public function GenerateDropDown($id, $data)
        {
            echo "<select name='" . $id . "' id='" . $id . "' class='form-select'>"; //style='max-width: 300px;'

            for ($i = 0; $i < count($data); $i++)
            {
                echo "<option data-val='" . $data[$i][0] . "'>" . $data[$i][1] . "</option>";
            }

            echo "</select>";
        }
        
        public function GenerateDisabledDropDown($id, $data)
        {
            echo "<select name='" . $id . "' id='" . $id . "' class='form-select' disabled='true'>"; //style='max-width: 300px;'

            for ($i = 0; $i < count($data); $i++)
            {
                echo "<option data-val='" . $data[$i][0] . "'>" . $data[$i][1] . "</option>";
            }

            echo "</select>";
        }

        public function GenerateMultipledDropDown($id, $data)
        {
            echo "<select name='" . $id . "' id='" . $id . "' class='form-select' multiple title='Hold the Ctrl Key and click each file you want to selec'>"; //style='max-width: 300px;'

            for ($i = 0; $i < count($data); $i++)
            {
                echo "<option value='" . $data[$i][0] . "'>" . $data[$i][1] . "</option>";
            }

            echo "</select>";
        }                 
    }

?>