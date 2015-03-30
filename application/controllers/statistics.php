<?php

class Statistics extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->helper(array('form', 'url'));
        $this->load->model('Mquery');
        $this->load->library('jpgraph');
        $this->load->library('mystatistics');
    }

    function statistics() {
        parent::CI_Controller();
    }

    function sta() {
        $this->load->view('statistics_view');
    }

    function data_input() {
        $this->load->view("datainput_view");
    }

    function data_save() {
        $this->load->view("datasave_view");
    }

    function save() {
        $this->load->view("save_view");
    }

    function input_db() {
        $this->load->view('sta_input_db');
    }

    function input_fl() {
        $this->load->view('sta_input_fl');
    }

    function sta_des_select() {
        $this->load->view('sta_select');
    }

    function sta_input() {
        $this->load->view('dataanalysis_view');
    }

    function trend_ana() {
        $this->load->view('trend_analysis');
    }

    function graph_create() {
        $this->load->view('graph_create');
    }

    function sta_des() {
        $this->load->view('sta_ana_des');
    }

    function sta_com() {
        $this->load->view('sta_ana_com');
    }

    function sta_gra_des() {
        $this->load->view('sta_gra_view_des');
    }

    function sta_gra_com() {
        $this->load->view('sta_gra_view_com');
    }

    function des_combine_yearly($more_result, $less_result) {
        $max_num = count($more_result);
        $min_num = count($less_result);
        $final_result = array();
        $temp_j = 0;
        for ($i = 0; $i < $max_num; $i++) {
            $temp2 = $more_result[$i]['start_time'];
            $secondyear = substr($temp2, -4);

            for ($j = $temp_j; $j < $min_num; $j++) {
                $temp1 = $less_result[$j]['start_time'];
                $firstyear = substr($temp1, -4);
                if ($firstyear >= $secondyear) {
                    $final_result[] = $more_result[$i];
                    $temp_j = $j;
                    break;
                } else {
                    $final_result[] = $less_result[$j];
                }
            }
            if ($j == $min_num) {
                $temp_i = $i;
                $temp_j = $j;
                break;
            }
        }
        if ($i == $max_num)
            $temp_i = $i;
        //add in the remaining values.
        if ($temp_j < $min_num - 1) {
            for ($k = $temp_j; $k < $min_num; $k++) {
                $final_result[] = $less_result[$k];
            }
        } else if ($temp_i < $max_num - 1) {
            for ($k = $temp_i; $k < $max_num; $k++) {
                $final_result[] = $more_result[$k];
            }
        }
        return $final_result;
    }

    function des_combine_monthly($more_result, $less_result) {
        $max_num = count($more_result);
        $min_num = count($less_result);
        $final_result = array();
        $temp_j = 0;
        for ($i = 0; $i < $max_num; $i++) {
            $temp2 = $more_result[$i]['start_time'];
            $first = strrpos($temp2, '/', -6);
            $secondmonth = substr($temp2, 0, $first);
            $secondyear = substr($temp2, -4);

            for ($j = $temp_j; $j < $min_num; $j++) {
                $temp1 = $less_result[$j]['start_time'];
                $first = strrpos($temp1, '/', -6);
                $firstmonth = substr($temp1, 0, $first);
                $firstyear = substr($temp1, -4);
                if ($firstyear > $secondyear || ($firstyear == $secondyear && $firstmonth > $secondmonth)) {
                    $final_result[] = $more_result[$i];
                    $temp_j = $j;
                    break;
                } else {
                    $final_result[] = $less_result[$j];
                }
            }
            if ($j == $min_num) {
                $temp_i = $i;
                $temp_j = $j;
                break;
            }
        }
        if ($i == $max_num)
            $temp_i = $i;
        //add in the remaining values.
        if ($temp_j < $min_num - 1) {
            for ($k = $temp_j; $k < $min_num; $k++) {
                $final_result[] = $less_result[$k];
            }
        } else if ($temp_i < $max_num - 1) {
            for ($k = $temp_i; $k < $max_num; $k++) {
                $final_result[] = $more_result[$k];
            }
        }
        return $final_result;
    }

    function des_submerge_season($data) {

        if (count($data) == 2) {
            $result = $data[0];
            $result['dspring'] = $data[0]['dspring'] + $data[1]['dspring'];
            $result['dwinter'] = $data[0]['dwinter'] + $data[1]['dwinter'];
            $result['dsummer'] = $data[0]['dsummer'] + $data[1]['dsummer'];
            $result['dfall'] = $data[0]['dfall'] + $data[1]['dfall'];

            $result['spring'] = ($data[1]['spring'] + $data[0]['spring']) / 2;
            $result['summer'] = ($data[1]['summer'] + $data[0]['summer']) / 2;
            $result['fall'] = ($data[1]['fall'] + $data[0]['fall']) / 2;
            $result['winter'] = ($data[1]['winter'] + $data[0]['winter']) / 2;
            return $result;
        }
        if (count($data) == 1) {

            return $data[0];
        }
        if (count($data) > 2) {
            $result = $data[0];
            $springvalueformiddle = array();
            $summervalueformiddle = array();
            $fallvalueformiddle = array();
            $wintervalueformiddle = array();
            $result['dspring'] = 0;
            $result['dsummer'] = 0;
            $result['dfall'] = 0;
            $result['dwinter'] = 0;
            $result['spring'] = null;
            $result['summer'] = null;
            $result['fall'] = null;
            $result['winter'] = null;
            $count = count($data); //total numbers in array
            for ($i = 0; $i < $count; $i++) {
                if ($data[$i]['spring'] != null) {
                    $springvalueformiddle[] = $data[$i]['spring'];
                    $result['dspring']+=$data[$i]['dspring'];
                }
                if ($data[$i]['summer'] != null) {
                    $summervalueformiddle[] = $data[$i]['summer'];
                    $result['dsummer']+=$data[$i]['dsummer'];
                }
                if ($data[$i]['fall'] != null) {
                    $result['dfall']+=$data[$i]['dfall'];
                    $fallvalueformiddle[] = $data[$i]['fall'];
                }
                if ($data[$i]['winter'] != null) {
                    $wintervalueformiddle[] = $data[$i]['winter'];
                    $result['dwinter']+=$data[$i]['dwinter'];
                }
            }

            if ($springvalueformiddle != null) {
                sort($springvalueformiddle);
                $result['spring'] = $this->des_mergesorted($springvalueformiddle);
            }
            if ($summervalueformiddle != null) {
                sort($summervalueformiddle);
                $result['summer'] = $this->des_mergesorted($summervalueformiddle);
            }
            if ($fallvalueformiddle != null) {
                sort($fallvalueformiddle);
                $result['fall'] = $this->des_mergesorted($fallvalueformiddle);
            }
            if ($wintervalueformiddle != null) {
                sort($wintervalueformiddle);
                $result['winter'] = $this->des_mergesorted($wintervalueformiddle);
            }
            return $result;
        }
    }

    function des_mergesorted($data) {
        if (count($data) == 1) {
            return $data[0];
        } else if (count($data) == 2) {
            return ($data[0] + $data[1]) / 2;
        } else if (count($data) > 2) {
            $count = count($data);
            $middleval = floor(($count - 1) / 2); // find the middle value, or the lowest middle value
            if ($count % 2) { // odd number, middle is the median
                $median = $data[$middleval];
            } else { // even number, calculate avg of 2 medians
                $low = $data[$middleval]['value'];
                $high = $data[$middleval + 1]['value'];
                $median = (($low + $high) / 2);
            }
            $result['value'] = $median;
            return $result;
        }
    }

    function des_submerge($data) {
        if (count($data) == 2) {
            $result = $data[0];
            $result['density'] = $data[0]['density'] + $data[1]['density'];
            $result['value'] = ($data[1]['value'] + $data[0]['value']) / 2;
            return $result;
        }
        if (count($data) == 1) {

            return $data[0];
        }
        if (count($data) > 2) {
            $result = $data[0];
            $valueformiddle = array();
            $count = count($data); //total numbers in array
            for ($i = 0; $i < $count; $i++) {
                $valueformiddle[] = $data[$i]['value'];
            }
            $valuesorted = $valueformiddle;
            sort($valuesorted);
            $middleval = floor(($count - 1) / 2); // find the middle value, or the lowest middle value
            if ($count % 2) { // odd number, middle is the median
                $median = $valuesorted[$middleval];
            } else { // even number, calculate avg of 2 medians
                $low = $valuesorted[$middleval];
                $high = $valuesorted[$middleval + 1];
                $median = (($low + $high) / 2);
            }
            $result['value'] = $median;
            $result['density'] = 0;
            for ($i = 0; $i < $count; $i++) {
                $result['density']+=$data[$i]['density'];
            }
            return $result;
        }
    }

    function des_merge($data, $by) {
        $final = array();
        $temp = array();
        $result = $data['sta_mean'];
        $temp[] = $result[0];
        //merge monthly value
        if ($by == 1) {
            for ($i = 0; $i < count($result) - 1; $i++) {
                $temp1 = $result[$i + 1]['start_time'];
                $first = strrpos($temp1, '/', -6);
                $firstmonth = substr($temp1, 0, $first);
                $firstyear = substr($temp1, -4);
                $temp1 = $result[$i]['start_time'];
                $first = strrpos($temp1, '/', -6);
                $secondmonth = substr($temp1, 0, $first);
                $secondyear = substr($temp1, -4);
                if ($firstyear == $secondyear && $firstmonth == $secondmonth) {
                    $temp[] = $result[$i + 1];
                } else {
                    $final[] = $this->des_submerge($temp);
                    $temp = array();
                    $temp[] = $result[$i + 1];
                    if ($i == (count($result) - 2)) {
                        $final[] = $temp[0];
                    }
                }
            }
            $data['sta_mean'] = $final;
        }
        //merge yearly, seasonly value
        else if ($by == 2) {
            for ($i = 0; $i < count($result) - 1; $i++) {
                $temp1 = $result[$i + 1]['start_time'];
                $firstyear = substr($temp1, -4);
                $temp1 = $result[$i]['start_time'];
                $secondyear = substr($temp1, -4);
                if ($firstyear == $secondyear) {
                    $temp[] = $result[$i + 1];
                } else {
                    $final[] = $this->des_submerge($temp);
                    $temp = array();
                    $temp[] = $result[$i + 1];
                    if ($i == count($result) - 2) {
                        $final[] = $temp[0];
                    }
                }
            }
            $data['sta_mean'] = $final;
        } else if ($by == 3) {
            for ($i = 0; $i < count($result) - 1; $i++) {
                $temp1 = $result[$i + 1]['start_time'];
                $firstyear = substr($temp1, -4);
                $temp1 = $result[$i]['start_time'];
                $secondyear = substr($temp1, -4);
                if ($firstyear == $secondyear) {
                    $temp[] = $result[$i + 1];
                } else {
                    $final[] = $this->des_submerge_season($temp);
                    $temp = array();
                    $temp[] = $result[$i + 1];
                    if ($i == count($result) - 2) {
                        $final[] = $temp[0];
                    }
                }
            }
            $data['sta_mean'] = $final;
        }
        $final = array();
        $temp = array();
        $result = $data['sta_median'];
        $temp[] = $result[0];
        //merge monthly value
        if ($by == 1) {
            for ($i = 0; $i < count($result) - 1; $i++) {
                $temp1 = $result[$i + 1]['start_time'];
                $first = strrpos($temp1, '/', -6);
                $firstmonth = substr($temp1, 0, $first);
                $firstyear = substr($temp1, -4);
                $temp1 = $result[$i]['start_time'];
                $first = strrpos($temp1, '/', -6);
                $secondmonth = substr($temp1, 0, $first);
                $secondyear = substr($temp1, -4);
                if ($firstyear == $secondyear && $firstmonth == $secondmonth) {
                    $temp[] = $result[$i + 1];
                } else {
                    $final[] = $this->des_submerge($temp);
                    $temp = array();
                    $temp[] = $result[$i + 1];
                    if ($i == (count($result) - 2)) {
                        $final[] = $temp[0];
                    }
                }
            }
            $data['sta_median'] = $final;
        }
        //merge yearly, seasonly value
        else if ($by == 2) {
            for ($i = 0; $i < count($result) - 1; $i++) {
                $temp1 = $result[$i + 1]['start_time'];
                $firstyear = substr($temp1, -4);
                $temp1 = $result[$i]['start_time'];
                $secondyear = substr($temp1, -4);
                if ($firstyear == $secondyear) {
                    $temp[] = $result[$i + 1];
                } else {
                    $final[] = $this->des_submerge($temp);
                    $temp = array();
                    $temp[] = $result[$i + 1];
                    if ($i == count($result) - 2) {
                        $final[] = $temp[0];
                    }
                }
            }
            $data['sta_median'] = $final;
        } else if ($by == 3) {
            for ($i = 0; $i < count($result) - 1; $i++) {
                $temp1 = $result[$i + 1]['start_time'];
                $firstyear = substr($temp1, -4);
                $temp1 = $result[$i]['start_time'];
                $secondyear = substr($temp1, -4);
                if ($firstyear == $secondyear) {
                    $temp[] = $result[$i + 1];
                } else {
                    $final[] = $this->des_submerge_season($temp);
                    $temp = array();
                    $temp[] = $result[$i + 1];
                    if ($i == count($result) - 2) {
                        $final[] = $temp[0];
                    }
                }
            }
            $data['sta_median'] = $final;
        }
        $final = array();
        $temp = array();
        $result = $data['sta_variance'];
        $temp[] = $result[0];
        //merge monthly value
        if ($by == 1) {
            for ($i = 0; $i < count($result) - 1; $i++) {
                $temp1 = $result[$i + 1]['start_time'];
                $first = strrpos($temp1, '/', -6);
                $firstmonth = substr($temp1, 0, $first);
                $firstyear = substr($temp1, -4);
                $temp1 = $result[$i]['start_time'];
                $first = strrpos($temp1, '/', -6);
                $secondmonth = substr($temp1, 0, $first);
                $secondyear = substr($temp1, -4);
                if ($firstyear == $secondyear && $firstmonth == $secondmonth) {
                    $temp[] = $result[$i + 1];
                } else {
                    $final[] = $this->des_submerge($temp);
                    $temp = array();
                    $temp[] = $result[$i + 1];
                    if ($i == (count($result) - 2)) {
                        $final[] = $temp[0];
                    }
                }
            }
            $data['sta_variance'] = $final;
        }
        //merge yearly, seasonly value
        else if ($by == 2) {
            for ($i = 0; $i < count($result) - 1; $i++) {
                $temp1 = $result[$i + 1]['start_time'];
                $firstyear = substr($temp1, -4);
                $temp1 = $result[$i]['start_time'];
                $secondyear = substr($temp1, -4);
                if ($firstyear == $secondyear) {
                    $temp[] = $result[$i + 1];
                } else {
                    $final[] = $this->des_submerge($temp);
                    $temp = array();
                    $temp[] = $result[$i + 1];
                    if ($i == count($result) - 2) {
                        $final[] = $temp[0];
                    }
                }
            }
            $data['sta_variance'] = $final;
        } else if ($by == 3) {
            for ($i = 0; $i < count($result) - 1; $i++) {
                $temp1 = $result[$i + 1]['start_time'];
                $firstyear = substr($temp1, -4);
                $temp1 = $result[$i]['start_time'];
                $secondyear = substr($temp1, -4);
                if ($firstyear == $secondyear) {
                    $temp[] = $result[$i + 1];
                } else {
                    $final[] = $this->des_submerge_season($temp);
                    $temp = array();
                    $temp[] = $result[$i + 1];
                    if ($i == count($result) - 2) {
                        $final[] = $temp[0];
                    }
                }
            }
            $data['sta_variance'] = $final;
        }
        $final = array();
        $temp = array();
        $result = $data['sta_max'];
        $temp[] = $result[0];
        //merge monthly value
        if ($by == 1) {
            for ($i = 0; $i < count($result) - 1; $i++) {
                $temp1 = $result[$i + 1]['start_time'];
                $first = strrpos($temp1, '/', -6);
                $firstmonth = substr($temp1, 0, $first);
                $firstyear = substr($temp1, -4);
                $temp1 = $result[$i]['start_time'];
                $first = strrpos($temp1, '/', -6);
                $secondmonth = substr($temp1, 0, $first);
                $secondyear = substr($temp1, -4);
                if ($firstyear == $secondyear && $firstmonth == $secondmonth) {
                    $temp[] = $result[$i + 1];
                } else {
                    $final[] = $this->des_submerge($temp);
                    $temp = array();
                    $temp[] = $result[$i + 1];
                    if ($i == (count($result) - 2)) {
                        $final[] = $temp[0];
                    }
                }
            }
            $data['sta_max'] = $final;
        }
        //merge yearly, seasonly value
        else if ($by == 2) {
            for ($i = 0; $i < count($result) - 1; $i++) {
                $temp1 = $result[$i + 1]['start_time'];
                $firstyear = substr($temp1, -4);
                $temp1 = $result[$i]['start_time'];
                $secondyear = substr($temp1, -4);
                if ($firstyear == $secondyear) {
                    $temp[] = $result[$i + 1];
                } else {
                    $final[] = $this->des_submerge($temp);
                    $temp = array();
                    $temp[] = $result[$i + 1];
                    if ($i == count($result) - 2) {
                        $final[] = $temp[0];
                    }
                }
            }
            $data['sta_max'] = $final;
        } else if ($by == 3) {
            for ($i = 0; $i < count($result) - 1; $i++) {
                $temp1 = $result[$i + 1]['start_time'];
                $firstyear = substr($temp1, -4);
                $temp1 = $result[$i]['start_time'];
                $secondyear = substr($temp1, -4);
                if ($firstyear == $secondyear) {
                    $temp[] = $result[$i + 1];
                } else {
                    $final[] = $this->des_submerge_season($temp);
                    $temp = array();
                    $temp[] = $result[$i + 1];
                    if ($i == count($result) - 2) {
                        $final[] = $temp[0];
                    }
                }
            }
            $data['sta_max'] = $final;
        }
        $final = array();
        $temp = array();
        $result = $data['sta_min'];
        $temp[] = $result[0];
        //merge monthly value
        if ($by == 1) {
            for ($i = 0; $i < count($result) - 1; $i++) {
                $temp1 = $result[$i + 1]['start_time'];
                $first = strrpos($temp1, '/', -6);
                $firstmonth = substr($temp1, 0, $first);
                $firstyear = substr($temp1, -4);
                $temp1 = $result[$i]['start_time'];
                $first = strrpos($temp1, '/', -6);
                $secondmonth = substr($temp1, 0, $first);
                $secondyear = substr($temp1, -4);
                if ($firstyear == $secondyear && $firstmonth == $secondmonth) {
                    $temp[] = $result[$i + 1];
                } else {
                    $final[] = $this->des_submerge($temp);
                    $temp = array();
                    $temp[] = $result[$i + 1];
                    if ($i == (count($result) - 2)) {
                        $final[] = $temp[0];
                    }
                }
            }
            $data['sta_min'] = $final;
        }
        //merge yearly, seasonly value
        else if ($by == 2) {
            for ($i = 0; $i < count($result) - 1; $i++) {
                $temp1 = $result[$i + 1]['start_time'];
                $firstyear = substr($temp1, -4);
                $temp1 = $result[$i]['start_time'];
                $secondyear = substr($temp1, -4);
                if ($firstyear == $secondyear) {
                    $temp[] = $result[$i + 1];
                } else {
                    $final[] = $this->des_submerge($temp);
                    $temp = array();
                    $temp[] = $result[$i + 1];
                    if ($i == count($result) - 2) {
                        $final[] = $temp[0];
                    }
                }
            }
            $data['sta_min'] = $final;
        } else if ($by == 3) {
            for ($i = 0; $i < count($result) - 1; $i++) {
                $temp1 = $result[$i + 1]['start_time'];
                $firstyear = substr($temp1, -4);
                $temp1 = $result[$i]['start_time'];
                $secondyear = substr($temp1, -4);
                if ($firstyear == $secondyear) {
                    $temp[] = $result[$i + 1];
                } else {
                    $final[] = $this->des_submerge_season($temp);
                    $temp = array();
                    $temp[] = $result[$i + 1];
                    if ($i == count($result) - 2) {
                        $final[] = $temp[0];
                    }
                }
            }
            $data['sta_min'] = $final;
        }
        return $data;
    }

    function des_combine($source1, $source2, $by) {
        $less_result;
        $more_result;
        $temp1;
        $temp2;
        $num_result1 = 0;
        $num_result2 = 0;
        $data = array();
        $result1 = $source1['sta_mean'];
        $num_result1 = count($result1);

        $result2 = $source2['sta_mean'];
        $num_result2 = count($result2);

        if ($num_result1 == 0 && $num_result2 != 0)
            return $source2;
        else if ($num_result2 == 0 && $num_result1 != 0)
            return $source1;
        else if ($num_result1 == 0 && $num_result2 == 0)
            return null;
        else {
            //do the combination
            if ($num_result1 <= $num_result2) {
                $min_num = $num_result1;
                $less_result = $result1;
                $max_num = $num_result2;
                $more_result = $result2;
            } else {
                $min_num = $num_result2;
                $less_result = $result2;
                $max_num = $num_result1;
                $more_result = $result1;
            }
            //combine the seasonally value
            if ($by == 3) {
                $final_result = $this->des_combine_yearly($more_result, $less_result);
            }
            //combine the yearly value
            if ($by == 1) {
                $final_result = $this->des_combine_monthly($more_result, $less_result);
            }
            //combine the monthly value
            if ($by == 2) {
                $final_result = $this->des_combine_yearly($more_result, $less_result);
            }
            $data['sta_mean'] = $final_result;
        }



        $result1 = $source1['sta_median'];
        $num_result1 = count($result1);

        $result2 = $source2['sta_median'];
        $num_result2 = count($result2);

        if ($num_result1 == 0 && $num_result2 != 0)
            return $source2;
        else if ($num_result2 == 0 && $num_result1 != 0)
            return $source1;
        else if ($num_result1 == 0 && $num_result2 == 0)
            return null;
        else {
            //do the combination
            if ($num_result1 <= $num_result2) {
                $min_num = $num_result1;
                $less_result = $result1;
                $max_num = $num_result2;
                $more_result = $result2;
            } else {
                $min_num = $num_result2;
                $less_result = $result2;
                $max_num = $num_result1;
                $more_result = $result1;
            }
            //combine the seasonally value
            if ($by == 3) {
                $final_result = $this->des_combine_yearly($more_result, $less_result);
            }
            //combine the yearly value
            if ($by == 1) {
                $final_result = $this->des_combine_monthly($more_result, $less_result);
            }
            //combine the monthly value
            if ($by == 2) {
                $final_result = $this->des_combine_yearly($more_result, $less_result);
            }
            $data['sta_median'] = $final_result;
        }


        $result1 = $source1['sta_variance'];
        $num_result1 = count($result1);

        $result2 = $source2['sta_variance'];
        $num_result2 = count($result2);

        if ($num_result1 == 0 && $num_result2 != 0)
            return $source2;
        else if ($num_result2 == 0 && $num_result1 != 0)
            return $source1;
        else if ($num_result1 == 0 && $num_result2 == 0)
            return null;
        else {
            //do the combination
            if ($num_result1 <= $num_result2) {
                $min_num = $num_result1;
                $less_result = $result1;
                $max_num = $num_result2;
                $more_result = $result2;
            } else {
                $min_num = $num_result2;
                $less_result = $result2;
                $max_num = $num_result1;
                $more_result = $result1;
            }
            //combine the seasonally value
            if ($by == 3) {
                $final_result = $this->des_combine_yearly($more_result, $less_result);
            }
            //combine the yearly value
            if ($by == 1) {
                $final_result = $this->des_combine_monthly($more_result, $less_result);
            }
            //combine the monthly value
            if ($by == 2) {
                $final_result = $this->des_combine_yearly($more_result, $less_result);
            }
            $data['sta_variance'] = $final_result;
        }

        $result1 = $source1['sta_max'];
        $num_result1 = count($result1);

        $result2 = $source2['sta_max'];
        $num_result2 = count($result2);

        if ($num_result1 == 0 && $num_result2 != 0)
            return $source2;
        else if ($num_result2 == 0 && $num_result1 != 0)
            return $source1;
        else if ($num_result1 == 0 && $num_result2 == 0)
            return null;
        else {
            //do the combination
            if ($num_result1 <= $num_result2) {
                $min_num = $num_result1;
                $less_result = $result1;
                $max_num = $num_result2;
                $more_result = $result2;
            } else {
                $min_num = $num_result2;
                $less_result = $result2;
                $max_num = $num_result1;
                $more_result = $result1;
            }
            //combine the seasonally value
            if ($by == 3) {
                $final_result = $this->des_combine_yearly($more_result, $less_result);
            }
            //combine the yearly value
            if ($by == 1) {
                $final_result = $this->des_combine_monthly($more_result, $less_result);
            }
            //combine the monthly value
            if ($by == 2) {
                $final_result = $this->des_combine_yearly($more_result, $less_result);
            }
            $data['sta_max'] = $final_result;
        }

        $result1 = $source1['sta_min'];
        $num_result1 = count($result1);

        $result2 = $source2['sta_min'];
        $num_result2 = count($result2);

        if ($num_result1 == 0 && $num_result2 != 0)
            return $source2;
        else if ($num_result2 == 0 && $num_result1 != 0)
            return $source1;
        else if ($num_result1 == 0 && $num_result2 == 0)
            return null;
        else {
            //do the combination
            if ($num_result1 <= $num_result2) {
                $min_num = $num_result1;
                $less_result = $result1;
                $max_num = $num_result2;
                $more_result = $result2;
            } else {
                $min_num = $num_result2;
                $less_result = $result2;
                $max_num = $num_result1;
                $more_result = $result1;
            }
            //combine the seasonally value
            if ($by == 3) {
                $final_result = $this->des_combine_yearly($more_result, $less_result);
            }
            //combine the yearly value
            if ($by == 1) {
                $final_result = $this->des_combine_monthly($more_result, $less_result);
            }
            //combine the monthly value
            if ($by == 2) {
                $final_result = $this->des_combine_yearly($more_result, $less_result);
            }
            $data['sta_min'] = $final_result;
        }

        return $data;
    }

    function do_des_analysis($result) {
        $data['tag'] = "des";
        $sta_method = $this->input->post('des_method');
        $by_time = $this->input->post('by_time');
        $data['by'] = $by_time;
        $data['sta_mean'] = $this->mystatistics->sta_mean($result, $by_time);
        $data['sta_median'] = $this->mystatistics->sta_median($result, $by_time);
        $data['sta_variance'] = $this->mystatistics->sta_variance($result, $by_time);
        $data['sta_min'] = $this->mystatistics->sta_min($result, $by_time);
        $data['sta_max'] = $this->mystatistics->sta_max($result, $by_time);
        return $data;
    }

    function des_analysis() {
        $stag = $this->session->userdata('sourcetag');
	$this->session->set_userdata('sta_result',null);
        $by_time = $this->input->post('by_time');
        $des_result['by'] = null;
        $des_result['sta_mean'] = null;
        $des_result['sta_median'] = null;
        $des_result['sta_variance'] = null;
        $des_result['sta_min'] = null;
        $des_result['sta_max'] = null;
        if ($stag != 'ALL') {
            $result = $this->session->userdata('myquery_result');
            //if seperate, do once
            if ($result != null) {
                if (count($result) > 0)
                    $des_result = $this->do_des_analysis($result);
            }

            $this->session->set_userdata('sta_result', $des_result);
            $this->load->view('descriptive_sta_result', $des_result);
        }
        //if ALL, do multiple times
        else if ($stag == 'ALL') {

            $result_tceq = $this->session->userdata('myquery_result_tceq');
            if ($result_tceq != null) {
                $des_tceq = $this->do_des_analysis($result_tceq);
            } else {
                $des_tceq = null;
            }
            $result_usgs = $this->session->userdata('myquery_result_usgs');
            if ($result_usgs != null) {
                $des_usgs = $this->do_des_analysis($result_usgs);
            } else {
                $des_usgs = null;
            }
	$result_tcequ = $this->session->userdata('myquery_result_tcequ');
            if ($result_tcequ != null) {
                $des_tcequ = $this->do_des_analysis($result_tcequ);
            } else {
                $des_tcequ = null;
            }
            $result_usgsu = $this->session->userdata('myquery_result_usgsu');
            if ($result_usgsu != null) {
                $des_usgsu = $this->do_des_analysis($result_usgsu);
            } else {
                $des_usgsu = null;
            }
            $result_othe = $this->session->userdata('myquery_result_othe');
            if ($result_othe != null) {
                $des_othe = $this->do_des_analysis($result_othe);
            } else {
                $des_othe = null;
            }
            if ($des_tceq != null && $des_usgs != null && $des_othe != null) {
                $des_mid_result = $this->des_combine($des_tceq, $des_usgs, $by_time);
                $des_result = $this->des_combine($des_mid_result, $des_othe, $by_time);
            } else if ($des_tceq != null && $des_usgs != null) {
                $des_result = $this->des_combine($des_tceq, $des_usgs, $by_time);
            } else if ($des_tceq != null && $des_othe != null) {
                $des_result = $this->des_combine($des_tceq, $des_othe, $by_time);
            } else if ($des_usgs != null && $des_othe != null) {
                $des_result = $this->des_combine($des_usgs, $des_othe, $by_time);
            } else if ($des_tceq != null) {
                $des_result = $des_tceq;
            } else if ($des_usgs != null) {
                $des_result = $des_usgs;
            } else if ($des_othe != null) {
                $des_result = $des_othe;
            }
            if ($des_tcequ != null && $des_usgsu != null && $des_result != null) {
                $des_mid_result = $this->des_combine($des_tcequ, $des_usgsu, $by_time);
                $des_finalresult = $this->des_combine($des_mid_result, $des_result, $by_time);
            } else if ($des_tcequ != null && $des_usgsu != null) {
                $des_finalresult = $this->des_combine($des_tcequ, $des_usgsu, $by_time);
            } else if ($des_tcequ != null && $des_result != null) {
                $des_finalresult = $this->des_combine($des_tcequ, $des_result, $by_time);
            } else if ($des_usgsu != null && $des_result != null) {
                $des_finalresult = $this->des_combine($des_usgsu, $des_result, $by_time);
            } else if ($des_tcequ != null) {
                $des_finalresult = $des_tcequ;
            } else if ($des_usgsu != null) {
                $des_finalresult = $des_usgsu;
            } else if ($des_result != null) {
                $des_finalresult = $des_result;
            }
            if ($des_finalresult != null) {
                $des_finalresult = $this->des_merge($des_finalresult, $by_time);
            }
            $des_finalresult['by'] = $by_time;
            $this->session->set_userdata('sta_result', $des_finalresult);
            $this->load->view('descriptive_sta_result', $des_finalresult);
        }
    }

    function data_scale(&$data) {
        if ($data == null)
            return null;
        $x = $data['xdata'];
        $y = $data['ydata'];

        $by = $data['by'];
        if ($by == 3) {
            $y_spring = $data['spring'];
            $y_summer = $data['summer'];
            $y_fall = $data['fall'];
            $y_winter = $data['winter'];
        }
        $month = array();
        $month[] = "01";
        $month[] = "02";
        $month[] = "03";
        $month[] = "04";
        $month[] = "05";
        $month[] = "06";
        $month[] = "07";
        $month[] = "08";
        $month[] = "09";
        $month[] = "10";
        $month[] = "11";
        $month[] = "12";
        if ($by == 2) {//scale by year
            $j = 0;
            $x_scale = array();
            $y_scale = array();
            for ($i = $x[0]; $i <= $x[count($x) - 1]; $i++) {
                $x_scale[] = $i;
                if ($i == $x[$j]) {
                    $y_scale[] = $y[$j];
                    $j++;
                } else {
                    $y_scale[] = "";
                }
            }
        } else if ($by == 3) {//scale by season
            $j = 0;
            $x_scale = array();
            $y_spring_scale = array();
            $y_summer_scale = array();
            $y_fall_scale = array();
            $y_winter_scale = array();
            for ($i = $x[0]; $i <= $x[count($x) - 1]; $i++) {
                $x_scale[] = $i;
                if ($i == $x[$j]) {

                    $y_spring_scale[] = $y_spring[$j];
                    $y_summer_scale[] = $y_summer[$j];
                    $y_fall_scale[] = $y_fall[$j];
                    $y_winter_scale[] = $y_winter[$j];
                    $j++;
                } else {
                    $y_spring_scale[] = "";
                    $y_summer_scale[] = "";
                    $y_fall_scale[] = "";
                    $y_winter_scale[] = "";
                }
            }
            $data['xdata'] = $x_scale;
            $data['spring'] = $y_spring_scale;
            $data['summer'] = $y_summer_scale;
            $data['fall'] = $y_fall_scale;
            $data['winter'] = $y_winter_scale;
            return $data;
        } else if ($by == 1) {//scale by month
            $j = 0;
            $x_scale = array();
            $y_scale = array();
            $start = substr($x[0], -4);
            $n = substr($x[count($x) - 1], -4);
            for ($i = $start; $i <= $n; $i++) {
                for ($k = 0; $k < 12; $k++) {
                    $x_scale[] = $month[$k] . '/' . $i;
                    $iny = substr($x[$j], -4);
		    $last = strrpos($x[$j], '/');
		    $inm=substr($x[$j],0,$last);
                    if ($i == $iny && $month[$k] == $inm) {
                        $y_scale[] = $y[$j];
                        if ($j < count($y) - 1)
                            $j++;
                        else
                            $j=count($y) - 1;
                    }
                    else {
                        $y_scale[] = "";
                    }
                }
            }
        }
        $data['xdata'] = $x_scale;
        $data['ydata'] = $y_scale;
        return $data;
    }

    function data_scale_lowess(&$data) {
        if ($data == null)
            return null;
        $x = $data['xdata'];
        $y = $data['ydata'];
        $month = array();
        $month[] = "01";
        $month[] = "02";
        $month[] = "03";
        $month[] = "04";
        $month[] = "05";
        $month[] = "06";
        $month[] = "07";
        $month[] = "08";
        $month[] = "09";
        $month[] = "10";
        $month[] = "11";
        $month[] = "12";
        $j = 0;
        $x_scale = array();
        $y_scale = array();
        $start = substr($x[0], -4);
        $n = substr($x[count($x) - 1], -4);
        for ($i = $start; $i <= $n; $i++) {
            for ($k = 0; $k < 12; $k++) {
                $x_scale[] = $month[$k] . '/' . $i;
                $iny = substr($x[$j], -4);

		$last = strrpos($x[$j], '/');
		$inm=substr($x[$j],0,$last);
                //$inm = substr($x[$j], 0, 2);
                if ($i == $iny && $month[$k] == $inm) {
                    $y_scale[] = $y[$j];
                    if ($j < count($y) - 1)
                        $j++;
                    else
                        $j=count($y) - 1;
                }
                else {
                    $y_scale[] = "";
                }
            }
        }
        $data['xdata'] = $x_scale;
        $data['ydata'] = $y_scale;
        return $data;
    }

    function creat_graph_com() {
        $data = $this->session->userdata('sta_result');
        $plot['title'] = $this->input->post('title');
        $paraname = $this->input->post('yaxis');
        $plot['yaxis'] = $paraname;
        if ($plot['yaxis'] == null) {
            $plot['yaxis'] = "variable";
        }if ($plot['title'] == null)
            $plot['title'] = "I guess you forget a title";
        $plot['type'] = $this->input->post('type');
        $plot['color'] = $this->input->post('color');
        $plot['weight'] = $this->input->post('weight');
        if ($plot['weight'] == null || $plot['weight'] > 10 || $plot['weight'] < 0

            )$plot['weight'] = 2;
        $plot['width'] = $this->input->post('width');
        if ($plot['width'] == null || $plot['width'] > 5500 || $plot['width'] < 0

            )$plot['width'] = 1400;
        $plot['length'] = $this->input->post('length');
        if ($plot['length'] == null || $plot['length'] > 1000 || $plot['length'] < 0

            )$plot['length'] = 300;
        $plot['step'] = $this->input->post('step');
        if ($plot['step'] == null || $plot['step'] > 50 || $plot['step'] < 0

            )$plot['step'] = 1;
        $plot['angle'] = $this->input->post('angle');
        if ($plot['angle'] == null || $plot['angle'] >= 360 || $plot['angle'] < 0

            )$plot['angle'] = 45;
        $filename = "./temp/image.png";
        $url = "../../temp/image.png";
        $plot['ydata'] = array();
        $plot['xdata'] = array();
        $test [] = array();
        $by_time = $data['by'];
        $plot['by'] = $by_time;

        if ($data['monthly_lowess'] != null) { //plot lowess;
            $i = 0;
            foreach ($data['monthly_lowess'] as $row) {
		$temp1 = $row['start_time'];
                $first = strrpos($temp1, '/', -6);
                $firstmonth = substr($temp1, 0, $first);
                $firstyear = substr($temp1, -4);
                $dateof = $firstmonth . "/" . $firstyear;
                $depth[] = $dateof;
                $value[] = $row['lowessapproxi'];
            }
?>
            <img src=<? echo $url; ?> alt="plot" >
<?
            $plot['xdata'] = $depth;
            $plot['ydata'] = $value;
            $this->data_scale_lowess($plot);
            if (count($depth) < 2)
                echo "Cannot Plot with Only One Value";
            else {
                if ($plot['type'] == 1)
                    $graph = $this->jpgraph->linechart($plot);
                else if ($plot['type'] == 2)
                    $graph = $this->jpgraph->scatterchart($plot);

                $graph->Stroke($filename);
            }
        } else {
            echo "No Data selected";
        }
    }

    function creat_graph_des() {
        $data = $this->session->userdata('sta_result');
        $plot['title'] = $this->input->post('title');
        $paraname = $this->input->post('yaxis');
        $plot['yaxis'] = $paraname;
        $plot['whichsta'] = $this->input->post('whichsta');
        if ($plot['yaxis'] == null) {
            $plot['yaxis'] = "variable";
        }if ($plot['title'] == null)
            $plot['title'] = "I guess you forget a title";
        $plot['type'] = $this->input->post('type');
        $plot['color'] = $this->input->post('color');
        $plot['weight'] = $this->input->post('weight');
        if ($plot['weight'] == null || $plot['weight'] > 10 || $plot['weight'] < 0)
            $plot['weight'] = 2;
        $plot['width'] = $this->input->post('width');
        if ($plot['width'] == null || $plot['width'] > 5500 || $plot['width'] < 0)
            $plot['width'] = 1400;
        $plot['length'] = $this->input->post('length');
        if ($plot['length'] == null || $plot['length'] > 1000 || $plot['length'] < 0)
            $plot['length'] = 300;
        $plot['step'] = $this->input->post('step');
        if ($plot['step'] == null || $plot['step'] > 50 || $plot['step'] < 0)
            $plot['step'] = 1;
        $plot['angle'] = $this->input->post('angle');
        if ($plot['angle'] == null || $plot['angle'] >= 360 || $plot['angle'] < 0)
            $plot['angle'] = 45;

        $filename = "./temp/image.png";
        $url = "../../temp/image.png";
        $plot['ydata'] = array();
        $plot['xdata'] = array();
        $test [] = array();
        $by_time = $data['by'];
        $plot['by'] = $data['by'];
        if ($plot['whichsta'] == 0) {
            $data['sta_value'] = $data['sta_mean'];
        } else if ($plot['whichsta'] == 1) {
            $data['sta_value'] = $data['sta_median'];
        } else if ($plot['whichsta'] == 2) {
            $data['sta_value'] = $data['sta_variance'];
        } else if ($plot['whichsta'] == 3) {
            $data['sta_value'] = $data['sta_max'];
        } else if ($plot['whichsta'] == 4) {
            $data['sta_value'] = $data['sta_min'];
        }

        if ($data['sta_value'] != null) {
            foreach ($data['sta_value'] as $row) {
                //record y value
                if ($by_time == 1 || $by_time == 2) {//yearly or monthly value
                    $plot['ydata'][] = $row['value'];
                }
                if ($by_time == 3) {
                    $plot['spring'][] = $row['spring'];
                    $plot['summer'][] = $row['summer'];
                    $plot['fall'][] = $row['fall'];
                    $plot['winter'][] = $row['winter'];
                }
                //record x value
                if ($by_time == 2 || $by_time == 3) {
                    //yearly or seasonnal, only record the year.
                    $plot['xdata'][] = substr($row['start_time'], -4);
                } else if ($by_time == 1) {
                    //monthly, only record the month/year
			$temp1 = $row['start_time'];
                $first = strrpos($temp1, '/', -6);
                $firstmonth = substr($temp1, 0, $first);
                $firstyear = substr($temp1, -4);
                    $plot['xdata'][] = $firstmonth . '/' . $firstyear;
                }
            }
            //if($by_time==2)
            $this->data_scale($plot);


            if (count($plot['xdata']) < 2)
                echo "Cannot Plot with Only One Point";
            else {
                if ($plot['type'] == 1)
                    $graph = $this->jpgraph->linechart($plot);
                else if ($plot['type'] == 2)
                    $graph = $this->jpgraph->scatterchart($plot);

                $graph->Stroke($filename);
?>
                <img src=<? echo $url; ?> alt="plot" >
<?
            }
        }
        else {
            echo "No Data selected";
        }
    }

    function do_com_analysis($result) {

        $column_names = array_keys($result[0]);
        $column_date = $column_names[4];
        $column_para = $column_names[7];
        $column_depth = $column_names[5];
        $f = $this->input->post('f');
        $cf = $this->input->post('const_f');
        $method = $this->input->post("method");
        if ($cf != null) {
            if ($cf > 1) {
                $cf = 1;
            }
            if ($cf < 0) {
                $cf = 0;
            }
        } else {
            $cf = 0.5; //default
        }
        $v = $this->input->post("vdepth");
        if ($v == null)
            $v = 0;
        $ftom = $this->input->post("ftom");
        $v = $v * $ftom;
        $nsteps = $this->input->post('iter');
        if ($nsteps > 50)
            $nsteps = 15;
        //get the column values

        $data_date = array();
        $data_para = array();
        $user_datef = $this->input->post('datefrom');
        $user_datet = $this->input->post("dateto");
        if ($user_datef != null && $user_datet != null) {
            $begin_year = substr($user_datef, -4);
            $end_year = substr($user_datet, -4);
        } else {
            if ($user_datef == null) {
                $begin_year = "1940";
                $end_year = substr($user_datet, -4);
            }
            if ($user_datet == null) {
                $end_year = "2013";
                $begin_year = substr($user_datef, -4);
            }
        }
        if ($begin_year > $end_year) {
            $temp = $end_year;
            $end_year = $begin_year;
            $begin_year = $temp;
        }

        foreach ($result as $row) {
            $year = substr($row[$column_date], -4);
            if ($year <= $end_year && $year >= $begin_year) {
                $data_date[] = $row[$column_date];
                $data_para[] = $row[$column_para];
                $data_depth[] = $row[$column_depth];
            }
        }
        if (count($data_date) > 0) {
            $monthly_lowess = array();
            $lowess_depth = array();
            $lowess_value = array();
            $lowess_depth [] = -10000;
            $lowess_value [] = 0;
            $start_time = $data_date[0];
            $lowess_depth[] = $data_depth[0];
            $lowess_value[] = $data_para[0];
            for ($i = 0; $i < count($data_date) - 1; $i++) {
                $first = strrpos($data_date[$i + 1], '/', -6);
                $last = strrpos($data_date[$i + 1], '/');
                $secondmonth = substr($data_date[$i + 1], 0, $first);
                $secondyear = substr($data_date[$i + 1], -4);

                $first = strrpos($start_time, '/', -6);
                $last = strrpos($start_time, '/');
                $firstmonth = substr($start_time, 0, $first);
                $firstyear = substr($start_time, -4);

                if ($firstmonth == $secondmonth && $firstyear == $secondyear) {
                    $lowess_depth[] = $data_depth[$i + 1];
                    $lowess_value[] = $data_para[$i + 1];
                    if ($i == (count($data_date) - 2)) {
                        if (count($lowess_depth) <= 1) {
                            continue;
                        }
                        array_multisort($lowess_depth, $lowess_value);
                        $lowess_update = $this->mystatistics->lowess($lowess_depth, $lowess_value, $f, $nsteps);
                        array_shift($lowess_update);
                        array_shift($lowess_depth);
                        //$monthly_lowess[] = array('start_time' => $start_time, 'depth' => $lowess_depth, 'lowess' => $lowess_update);
                        $lowess_approxi = $this->mystatistics->Rapprox($v, $lowess_depth, $lowess_update, $method, $cf);
                        $monthly_lowess[] = array('start_time' => $start_time, 'depth' => $lowess_depth, 'lowess' => $lowess_update, 'lowessapproxi' => $lowess_approxi);
                    }
                }
                //if not same month,
                //record the monthly average, continue to next month;
                else {
                    if (count($lowess_depth) <= 1) {
                        $start_time = $data_date[$i + 1];
                        $counts_density = 0;
                        $lowess_depth = array();
                        $lowess_value = array();
                        $lowess_depth [] = -10000;
                        $lowess_value [] = 0;
                        $lowess_depth[] = $data_depth[$i + 1];
                        $lowess_value[] = $data_para[$i + 1];
                        continue;
                    }
                    array_multisort($lowess_depth, $lowess_value);
                    $lowess_update = $this->mystatistics->lowess($lowess_depth, $lowess_value, $f, $nsteps);
                    array_shift($lowess_update);
                    array_shift($lowess_depth);
                    //$monthly_lowess[] = array('start_time' => $start_time, 'depth' => $lowess_depth, 'lowess' => $lowess_update);
                    $lowess_approxi = $this->mystatistics->Rapprox($v, $lowess_depth, $lowess_update, $method, $cf);
                    $monthly_lowess[] = array('start_time' => $start_time, 'depth' => $lowess_depth, 'lowess' => $lowess_update, 'lowessapproxi' => $lowess_approxi);
                    //next month value
                    $start_time = $data_date[$i + 1];
                    $counts_density = 0;
                    $lowess_depth = array();
                    $lowess_value = array();
                    $lowess_depth [] = -10000;
                    $lowess_value [] = 0;
                    $lowess_depth[] = $data_depth[$i + 1];
                    $lowess_value[] = $data_para[$i + 1];
                    //if the ($i+1) date is the last value, record the value.
                    if ($i == (count($data_date) - 2)) {
                        array_multisort($lowess_depth, $lowess_value);
                        $lowess_update = $this->mystatistics->lowess($lowess_depth, $lowess_value, $f, $nsteps);
                        array_shift($lowess_update);
                        array_shift($lowess_depth);
                        //$monthly_lowess[] = array('start_time' => $start_time, 'depth' => $lowess_depth, 'lowess' => $lowess_update);
                        $lowess_approxi = $this->mystatistics->Rapprox($v, $lowess_depth, $lowess_update, $method, $cf);
                        $monthly_lowess[] = array('start_time' => $start_time, 'depth' => $lowess_depth, 'lowess' => $lowess_update, 'lowessapproxi' => $lowess_approxi);
                    }
                }
            }
            $data['tag'] = 'lowess';
            $xys = null;
            $by = null;
            $data['vname'] = $result[0]['PARAMETER'];
            $data['monthly_lowess'] = $monthly_lowess;
            $data['sta_value'] = $xys;
            $data['original'] = $data_para;
            $data['by'] = $by;
            $data['vdepth'] = $v;
            return $data;
        }
    }

    function combine($source1, $source2) {
        $finalresult = array();
        $less_result;
        $more_result;
        $temp1;
        $temp2;
        $num_result1 = 0;
        $num_result2 = 0;

        $result1 = $source1['monthly_lowess'];
        $num_result1 = count($result1);

        $result2 = $source2['monthly_lowess'];
        $num_result2 = count($result2);

        if ($num_result1 == 0 && $num_result2 != 0)
            return $source2;
        else if ($num_result2 == 0 && $num_result1 != 0)
            return $source1;
        else if ($num_result1 == 0 && $num_result2 == 0)
            return null;
        else {

            //do the combination
            if ($num_result1 <= $num_result2) {
                $min_num = $num_result1;
                $less_result = $result1;
                $max_num = $num_result2;
                $more_result = $result2;
            } else {
                $min_num = $num_result2;
                $less_result = $result2;
                $max_num = $num_result1;
                $more_result = $result1;
            }
            $temp_j = 0;
            for ($i = 0; $i < $max_num; $i++) {
                $temp2 = $more_result[$i]['start_time'];
                $first = strrpos($temp2, '/', -6);
                $last = strrpos($temp2, '/');
                $secondday = substr($temp2, $first + 1, $last - $first - 1);
                $secondmonth = substr($temp2, 0, $first);
                $secondyear = substr($temp2, -4);

                for ($j = $temp_j; $j < $min_num; $j++) {
                    $temp1 = $less_result[$j]['start_time'];
                    $first = strrpos($temp1, '/', -6);
                    $last = strrpos($temp1, '/');
                    $firstday = substr($temp1, $first + 1, $last - $first - 1);
                    $firstmonth = substr($temp1, 0, $first);
                    $firstyear = substr($temp1, -4);
                    if ($firstyear > $secondyear || ($firstyear == $secondyear && $firstmonth > $secondmonth) || ($firstyear == $secondyear && $firstmonth == $secondmonth && $firstday > $secondday)) {
                        $final_result[] = $more_result[$i];
                        $temp_j = $j;
                        break;
                    } else {
                        $final_result[] = $less_result[$j];
                    }
                }
                if ($j == $min_num) {
                    $temp_i = $i;
                    $temp_j = $j;
                    break;
                }
            }
            if ($i == $max_num)
                $temp_i = $i;
            //add in the remaining values.
            if ($temp_j < $min_num - 1) {
                for ($k = $temp_j; $k < $min_num; $k++) {
                    $final_result[] = $less_result[$k];
                }
            } else if ($temp_i < $max_num - 1) {
                for ($k = $temp_i; $k < $max_num; $k++) {
                    $final_result[] = $more_result[$k];
                }
            }
        }
        $source1['monthly_lowess'] = $final_result;
        return $source1;
    }

    function submerge($data) {
        if (count($data) == 2) {
            $result = $data[0];
            $result['lowessapproxi'] = ($data[0]['lowessapproxi'] + $data[1]['lowessapproxi']) / 2;
            return $result;
        }
        if (count($data) == 1)
            return $data[0];
        if (count($data) > 3) {
            $result = $data[0];
            $count = count($data); //total numbers in array
            $middleval = floor(($count - 1) / 2); // find the middle value, or the lowest middle value
            if ($count % 2) { // odd number, middle is the median
                $median = $data[$middleval];
            } else { // even number, calculate avg of 2 medians
                $low = $data[$middleval]['lowessapproxi'];
                $high = $data[$middleval + 1]['lowessapproxi'];
                $median = (($low + $high) / 2);
            }
            $result['lowessapproxi'] = $median;
            return $result;
        }
    }

    function merge($data) {
        $final = array();
        $temp = array();
        $result = $data['monthly_lowess'];

        $temp[] = $result[0];
        for ($i = 0; $i < count($result) - 1; $i++) {
            $temp2 = $result[$i + 1]['start_time'];
            $first = strrpos($temp2, '/', -6);
            $secondmonth = substr($temp2, 0, $first);
            $secondyear = substr($temp2, -4);
            $temp2 = $result[$i]['start_time'];
            $first = strrpos($temp2, '/', -6);
            $firstmonth = substr($temp2, 0, $first);
            $firstyear = substr($temp2, -4);
            if ($firstyear == $secondyear && $firstmonth == $secondmonth) {
                $temp[] = $result[$i + 1];
            } else {
                $final[] = $this->submerge($temp);
                $temp = array();
                $temp[] = $result[$i + 1];
                if ($i == count($result) - 2) {
                    $final[] = $temp[0];
                }
            }
        }
        $data['monthly_lowess'] = $final;
        return $data;
    }

    function com_analysis() {
        $stag = $this->session->userdata('sourcetag');
	$this->session->set_userdata('sta_result',null);
        if ($stag != 'ALL') {
            $result = $this->session->userdata('myquery_result');
            //if seperate, do once
            if ($result != null) {
                $com_result = $this->do_com_analysis($result);
            }
            else
                $com_result=null;
            $this->session->set_userdata('sta_result', $com_result);
            $this->load->view('lowess_sta_result', $com_result);
        }
        //if ALL, do multiple times
        else if ($stag == 'ALL') {

            $result_tceq = $this->session->userdata('myquery_result_tceq');
            if ($result_tceq != null) {
                $com_tceq = $this->do_com_analysis($result_tceq);
            } else {
                $com_tceq = null;
            }
            $result_usgs = $this->session->userdata('myquery_result_usgs');
            if ($result_usgs != null) {
                $com_usgs = $this->do_com_analysis($result_usgs);
            } else {
                $com_usgs = null;
            }
	$result_tcequ = $this->session->userdata('myquery_result_tcequ');
            if ($result_tcequ != null) {
                $com_tcequ = $this->do_com_analysis($result_tcequ);
            } else {
                $com_tcequ = null;
            }
            $result_usgsu = $this->session->userdata('myquery_result_usgsu');
            if ($result_usgsu != null) {
                $com_usgsu = $this->do_com_analysis($result_usgsu);
            } else {
                $com_usgsu = null;
            }
            $result_othe = $this->session->userdata('myquery_result_othe');
            if ($result_othe != null) {
                $com_othe = $this->do_com_analysis($result_othe);
            } else {
                $com_othe = null;
            }
            if ($com_tceq != null && $com_usgs != null && $com_othe != null) {
                $com_mid_result = $this->combine($com_tceq, $com_usgs);
                $com_result = $this->combine($com_mid_result, $com_othe);
            } else if ($com_tceq != null && $com_usgs != null) {
                $com_result = $this->combine($com_tceq, $com_usgs);
            } else if ($com_tceq != null && $com_othe != null) {
                $com_result = $this->combine($com_tceq, $com_othe);
            } else if ($com_usgs != null && $com_othe != null) {
                $com_result = $this->combine($com_usgs, $com_othe);
            } else if ($com_tceq != null) {
                $com_result = $com_tceq;
            } else if ($com_usgs != null) {
                $com_result = $com_usgs;
            } else if ($com_othe != null) {
                $com_result = $com_othe;
            }

            if ($com_tcequ != null && $com_usgsu != null && $com_result != null) {
                $com_mid_result = $this->combine($com_tcequ, $com_usgsu);
                $com_finalresult = $this->combine($com_mid_result, $com_result);
            } else if ($com_tcequ != null && $com_usgsu != null) {
                $com_finalresult = $this->combine($com_tcequ, $com_usgsu);
            } else if ($com_tcequ != null && $com_result != null) {
                $com_finalresult = $this->combine($com_tcequ, $com_result);
            } else if ($com_usgsu != null && $com_result != null) {
                $com_finalresult = $this->combine($com_usgsu, $com_result);
            } else if ($com_tcequ != null) {
                $com_finalresult = $com_tcequ;
            } else if ($com_usgsu != null) {
                $com_finalresult = $com_usgsu;
            } else if ($com_result != null) {
                $com_finalresult = $com_result;
            }
            if ($com_finalresult != null) {
                $com_finalresult = $this->merge($com_finalresult);
            } else {
                $com_finalresult = null;
            }
            $this->session->set_userdata('sta_result', $com_finalresult);
            $this->load->view('lowess_sta_result', $com_finalresult);
        }
    }

}
?>
