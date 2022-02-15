<?php

    class DateTimePicker
    {
        public function GenerateDateTimePicker($id, $resetvalue = null)
        {
            if ($resetvalue == null)
                echo "<input type='date' id='" . $id . "' name='" . $id . "' class='form-control form-control-sm' value='" . date('Y-m-d') . "' onkeydown='return false'>";
            else
            {
                try
                {
                    echo "<input type='date' id='" . $id . "' name='" . $id . "' class='form-control form-control-sm' value='" . date('Y-m-d', strtotime($resetvalue)) . "' onkeydown='return false'>";
                }
                catch(Exception $e)
                {
                    echo "<input type='date' id='" . $id . "' name='" . $id . "' class='form-control form-control-sm' value='" . date('Y-m-d') . "' onkeydown='return false'>";
                }
            }
        }
    }

?>