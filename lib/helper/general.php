<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of general
 *
 * @author adrian
 */
class general {

    //put your code here

    public $dataSet = array();

    public function toLog($error) {

        $myfile = fopen("./lib/helper/error.log", "w") or die("Unable to open file!");
        fwrite($myfile, $error);
        fclose($myfile);
    }

    public function getConfig($key, $entity = 'default', $set = 'default') {


        if (file_exists("./model/" . $key . "/" . $entity . "/" . $set . ".json")) {

            $string = file_get_contents("./model/" . $key . "/" . $entity . "/" . $set . ".json");
            $json = json_decode($string, true);
            return $json;
        } else {
            return array();
        }
    }

    public function getConfigValues($SET) {


        $this->setValues($SET);

        $Values = $this->getDataValue($this->dataSet);

        $this->dataSet = array();

        return $Values;
    }

    public function setValues($SET, $KEY = '') {

        if (is_numeric($KEY)) {
            $KEY = '';
        }

        foreach ($SET as $keySET => $set) {



            if (is_array($set)) {

                if (is_numeric($keySET)) {
                    $key = $KEY;
                } else {
                    if ($KEY == '') {
                        $key = $keySET;
                    } else {
                        $key = $KEY . '.' . $keySET;
                    }
                }

                $this->setValues($set, $key);
            } else {


                $this->dataSet[] = $KEY . '.' . $keySET . '.' . $set;
            }
        }
    }

    public function getDataValue($setValue) {

        $dataValue = array();

        foreach ($setValue as $set) {

            $data = explode('.', $set);



            $total = count($data);

            $path = '';

            for ($i = 0; $i <= ($total - 2); $i++) {

                $path = $path . '/' . $data[$i];
            }



            $value = $this->getValue($path, $data[$total - 1]);



            $dataValue[$data[0]][] = $value;
        }
        return $dataValue;
    }

    public function getValue($data, $value) {

        if (file_exists("./model/" . $data . ".json")) {

            $string = file_get_contents("./model/" . $data . ".json");
            $json = json_decode($string, true);

            if (isset($json[$value])) {
                return $json[$value];
            } else {
                return array();
            }
        } else {

            return array();
        }
    }

}
