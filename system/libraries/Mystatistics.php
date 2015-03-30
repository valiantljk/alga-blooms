<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Mystatistics
 * This class consist of basic statistics analysis.
 * @author jialin
 */
class Mystatistics {

    //put your code here
    function calculate_median($arr) {
        if (count($arr) == 0)
            return "";
        sort($arr);
        $count = count($arr); //total numbers in array
        $middleval = floor(($count - 1) / 2); // find the middle value, or the lowest middle value
        if ($count % 2) { // odd number, middle is the median
            $median = $arr[$middleval];
        } else { // even number, calculate avg of 2 medians
            $low = $arr[$middleval];
            $high = $arr[$middleval + 1];
            $median = (($low + $high) / 2);
        }
        return $median;
    }

    function calculate_mean($arr) {
        if (count($arr) == 0)
            return "";
        $sum = 0;
        for ($i = 0; $i < count($arr); $i++) {
            $sum+= $arr[$i];
        }
        return (float) $sum / count($arr);
    }

    function calculate_variance($arr, $ave) {

        $sum = 0;
        for ($i = 0; $i < count($arr); $i++) {
            $sum+= ( $arr[$i] - $ave) * ($arr[$i] - $ave);
        }
        return (float) $sum / count($arr);
    }

    function single_calculate_variance($arr) {
        if (count($arr) == 0)
            return NULL;
        $ave = $this->calculate_mean($arr);
        return $this->calculate_variance($arr, $ave);
    }

    function sta_mean($result, $by) {
        $column_names = array_keys($result[0]);
        $column_date = $column_names[4];
        $column_para = $column_names[7];
        //get the column values
        $data_date = array();
        $data_para = array();
        foreach ($result as $row) {
            $data_date[] = $row[$column_date];
            $data_para[] = $row[$column_para];
        }
        //monthly average
        if ($by == 1) {
            $counts_density = 0;
            $sum = (float) $data_para[0];
            $average = 0;
            $start_time = $data_date[0];
            $monthly_mean = array();
            if (count($data_date) == 1) {
                $monthly_mean[] = array('start_time' => $start_time, 'density' => 1, 'value' => $data_para[0]);
            }
            for ($i = 0; $i < count($data_date) - 1; $i++) {

                //$firstmonth = substr($start_time, 0, 2);
                //$firstyear = substr($start_time, -4);
                $temp2 = $start_time;
                $first = strrpos($temp2, '/', -6);
                $last = strrpos($temp2, '/');

                $firstmonth = substr($temp2, 0, $first);
                $firstyear = substr($temp2, -4);
                $temp2 = $data_date[$i + 1];
                //$secondmonth = substr($data_date[$i + 1], 0, 2);
                //$secondyear = substr($data_date[$i + 1], -4);
                $first = strrpos($temp2, '/', -6);
                $last = strrpos($temp2, '/');
                $secondmonth = substr($temp2, 0, $first);
                $secondyear = substr($temp2, -4);
                //check the date, if same, then sum up.
                if ($firstmonth == $secondmonth && $firstyear == $secondyear) {
                    $counts_density++;
                    $sum+=(float) $data_para[$i + 1];
                    //if it's the last day, stop the loop here.
                    if ($i == (count($data_date) - 2)) {
                        $average = (float) $sum / ($counts_density + 1);
                        $monthly_mean[] = array('start_time' => $start_time, 'density' => ($counts_density + 1), 'value' => $average);
                    }
                }
                //if not same month,
                //record the monthly average, continue to next month;
                else {
                    $average = (float) $sum / ($counts_density + 1);
                    $monthly_mean[] = array('start_time' => $start_time, 'density' => ($counts_density + 1), 'value' => $average);
                    //next month value
                    $start_time = $data_date[$i + 1];
                    $counts_density = 0;
                    $sum = (float) $data_para[$i + 1];
                    //if the ($i+1) date is the last value, record the value.
                    if ($i == (count($data_date) - 2)) {
                        $monthly_mean[] = array('start_time' => $start_time, 'density' => ($counts_density + 1), 'value' => $sum);
                    }
                }
            }
            return $monthly_mean;
        }
        //yearly average
        if ($by == 2) {
            $counts_density = 0;
            $sum = (float) $data_para[0];
            $average = 0;
            $start_time = $data_date[0];
            $yearly_mean = array();
            if (count($data_date) == 1) {
                $yearly_mean[] = array('start_time' => $start_time, 'density' => 1, 'value' => $sum);
            }
            for ($i = 0; $i < count($data_date) - 1; $i++) {
                $firstyear = (string) substr((string) $start_time, -4);
                $secondyear = (string) substr((string) $data_date[$i + 1], -4);

                if ($firstyear == $secondyear) {
                    $counts_density++;
                    $sum+=(float) $data_para[$i + 1];
                    if ($i == (count($data_date) - 2)) {
                        $average = (float) $sum / ($counts_density + 1);
                        $yearly_mean[] = array('start_time' => $start_time, 'density' => ($counts_density + 1), 'value' => $average);
                    }
                }
                //record the yearly average, continue to next year;
                else {
                    $average = (float) $sum / ($counts_density + 1);
                    $yearly_mean[] = array('start_time' => $start_time, 'density' => ($counts_density + 1), 'value' => $average);
                    //update the value;
                    $start_time = $data_date[$i + 1];
                    $counts_density = 0;
                    $sum = (float) $data_para[$i + 1];
                    if ($i == (count($data_date) - 2)) {
                        $yearly_mean[] = array('start_time' => $start_time, 'density' => ($counts_density + 1), 'value' => $sum);
                    }
                }
            }
            return $yearly_mean;
        }
        //seasonly average
        if ($by == 3) {
            $counts_density = 0;
            $sum = (float) $data_para[0];
            $average = 0;
            $start_time = $data_date[0];
            $seanonally_mean = array();
            $spring = array();
            $summer = array();
            $fall = array();
            $winter = array();
            //$firstyear = substr($start_time, -4);
            //$firstmonth = substr($start_time, 0, 2);
            $temp2 = $start_time;
            $first = strrpos($temp2, '/', -6);
            $last = strrpos($temp2, '/');
            $firstmonth = substr($temp2, 0, $first);
            $firstdyear = substr($temp2, -4);

            $nextwinter = array();
            if (count($data_date) == 1) {
                if ($firstmonth == 12 || $firstmonth == 1 || $firstmonth == 2) {
                    $wi = $data_para[0];
                    $sp = "";
                    $su = "";
                    $fa = "";
                    if ($firstyear == 12)
                        $firstyear++;
                }
                if ($firstmonth == 3 || $firstmonth == 4 || $firstmonth == 5) {
                    $wi = "";
                    $sp = $data_para[0];
                    $su = "";
                    $fa = "";
                }
                if ($firstmonth == 6 || $firstmonth == 7 || $firstmonth == 8) {
                    $wi = "";
                    $sp = "";
                    $su = $data_para[0];
                    $fa = "";
                }
                if ($firstmonth == 9 || $firstmonth == 10 || $firstmonth == 11) {
                    $wi = "";
                    $sp = "";
                    $su = "";
                    $fa = $data_para[0];
                }
                if ($wi == null) {
                    $dwi = 0;
                } else {
                    $dwi = 1;
                }
                if ($su == null) {
                    $dsu = 0;
                } else {
                    $dsu = 1;
                }
                if ($sp == null) {
                    $dsp = 0;
                } else {
                    $dsp = 1;
                }
                if ($fa == null) {
                    $dfa = 0;
                } else {
                    $dfa = 1;
                }
                //$seanonally_median[] = array('start_time' => $firstyear, 'winter' => $wi,'spring' => $sp, 'summer' => $su, 'fall' => $fa,'dwinter'=>$dwi,'dspring'=>$dsp,'dsummer'=>$dsu,'dfall'=>$dfa);
                $seanonally_mean[] = array('start_time' => $firstyear, 'winter' => $wi,
                    'spring' => $sp, 'summer' => $su, 'fall' => $fa, 'dwinter' => $dwi, 'dspring' => $dsp, 'dsummer' => $dsu, 'dfall' => $dfa);
                return $seanonally_mean;
            }
            for ($i = 0; $i < count($data_date); $i++) {
                $firstyear = substr($start_time, -4);
                $secondyear = substr($data_date[$i], -4);
                //$firstmonth = substr($start_time, 0, 2);
                //$secondmonth = substr($data_date[$i], 0, 2);
                $temp2 = $start_time;
                $first = strrpos($temp2, '/', -6);
                $last = strrpos($temp2, '/');
                $firstmonth = substr($temp2, 0, $first);
                $temp2 = $data_date[$i];
                $first = strrpos($temp2, '/', -6);
                $last = strrpos($temp2, '/');
                $secondmonth = substr($temp2, 0, $first);
                if ($firstyear == $secondyear) {
                    if ($secondmonth == '12') {
                        $nextwinter[] = $data_para[$i];
                    } else {
                        //$spring+=$nextspring;
                        if ($secondmonth == '01' || $secondmonth == '02') {
                            $winter[] = (float) $data_para[$i];
                        }
                        //count the 3, 4, 5 into first year's summer
                        else if ($secondmonth == '03' || $secondmonth == '04' || $secondmonth == '05') {
                            $spring[] = (float) $data_para[$i];
                        }
                        //count the 6,7,8 into the first year's fall
                        else if ($secondmonth == '06' || $secondmonth == '07' || $secondmonth == '08') {
                            $summer[] = (float) $data_para[$i];
                        }
                        //count the 9, 10, 11 into the first year's winter
                        else if ($secondmonth == '09' || $secondmonth == '10' || $secondmonth == '11') {
                            $fall[] = (float) $data_para[$i];
                        }
                    }
                    if ($i == count($data_date) - 1) {
                        $seanonally_mean[] = array('start_time' => $firstyear, 'winter' => $this->calculate_mean($winter), 'spring' => $this->calculate_mean($spring),
                            'summer' => $this->calculate_mean($summer), 'fall' => $this->calculate_mean($fall), 'dwinter' => count($winter), 'dspring' => count($spring),
                            'dsummer' => count($summer), 'dfall' => count($fall));
                    }
                } else if ($firstyear == $secondyear - 1) {
                    //$spring=array_merge($spring,$nextspring);
                    //$nextspring = array();
                    $seanonally_mean[] = array('start_time' => $firstyear, 'winter' => $this->calculate_mean($winter),
                        'spring' => $this->calculate_mean($spring), 'summer' => $this->calculate_mean($summer), 'fall' => $this->calculate_mean($fall), 'dwinter' => count($winter), 'dspring' => count($spring), 'dsummer' => count($summer), 'dfall' => count($fall));
                    $winter = $nextwinter;
                    $nextwinter = array();
                    $spring = array();
                    $summer = array();
                    $fall = array();
                    if ($secondmonth == '12') {
                        $nextwinter[] = $data_para[$i];
                    } else {
                        //$spring+=$nextspring;
                        if ($secondmonth == '01' || $secondmonth == '02') {
                            $winter[] = (float) $data_para[$i];
                        }
                        //count the 3, 4, 5 into first year's summer
                        else if ($secondmonth == '03' || $secondmonth == '04' || $secondmonth == '05') {
                            $spring[] = (float) $data_para[$i];
                        }
                        //count the 6,7,8 into the first year's fall
                        else if ($secondmonth == '06' || $secondmonth == '07' || $secondmonth == '08') {
                            $summer[] = (float) $data_para[$i];
                        }
                        //count the 9, 10, 11 into the first year's winter
                        else if ($secondmonth == '09' || $secondmonth == '10' || $secondmonth == '11') {
                            $fall[] = (float) $data_para[$i];
                        }
                    }
                    $start_time = $data_date[$i];
                } else if ($firstyear < $secondyear - 1) {
                    $seanonally_mean[] = array('start_time' => $firstyear, 'winter' => $this->calculate_mean($winter),
                        'spring' => $this->calculate_mean($spring), 'summer' => $this->calculate_mean($summer), 'fall' => $this->calculate_mean($fall), 'dwinter' => count($winter), 'dspring' => count($spring), 'dsummer' => count($summer), 'dfall' => count($fall));
                    $winter = $nextwinter;
                    if ($winter != NULL) {
                        $seanonally_mean[] = array('start_time' => $firstyear + 1, 'winter' => $this->calculate_mean($winter),
                            'spring' => "", 'summer' => "", 'fall' => "", 'dwinter' => count($winter), 'dspring' => 0, 'dsummer' => 0, 'dfall' => 0);
                    }
                    $start_time = $data_date[$i];
                    $winter = array();
                    $spring = array();
                    $summer = array();
                    $fall = array();
                    if ($secondmonth == '12') {
                        $nextwinter[] = $data_para[$i];
                    } else {
                        //$spring+=$nextspring;
                        if ($secondmonth == '01' || $secondmonth == '02') {
                            $winter[] = (float) $data_para[$i];
                        }
                        //count the 3, 4, 5 into first year's summer
                        else if ($secondmonth == '03' || $secondmonth == '04' || $secondmonth == '05') {
                            $spring[] = (float) $data_para[$i];
                        }
                        //count the 6,7,8 into the first year's fall
                        else if ($secondmonth == '06' || $secondmonth == '07' || $secondmonth == '08') {
                            $summer[] = (float) $data_para[$i];
                        }
                        //count the 9, 10, 11 into the first year's winter
                        else if ($secondmonth == '09' || $secondmonth == '10' || $secondmonth == '11') {
                            $fall[] = (float) $data_para[$i];
                        }
                    }
                }
            }
            return $seanonally_mean;
        }
    }

    function sta_median($result, $by) {
        $column_names = array_keys($result[0]);
        $column_date = $column_names[4];
        $column_para = $column_names[7];
        //get the column values
        $data_date = array();
        $data_para = array();
        foreach ($result as $row) {
            $data_date[] = $row[$column_date];
            $data_para[] = $row[$column_para];
        }
        //monthly average
        if ($by == 1) {
            $counts_density = 0;
            $start_time = $data_date[0];
            $monthly_median = array();
            $monthly_temp = array();
            $monthly_temp[] = $data_para[0];
            if (count($data_date) == 1) {
                $monthly_median[] = array('start_time' => $start_time, 'density' => 1, 'value' => $data_para[0]);
            }
            for ($i = 0; $i < count($data_date) - 1; $i++) {
                //$firstmonth = substr($start_time, 0, 2);
                $firstyear = substr($start_time, -4);
                $temp2 = $start_time;
                $first = strrpos($temp2, '/', -6);
                $last = strrpos($temp2, '/');
                $firstmonth = substr($temp2, 0, $first);

                //$secondmonth = substr($data_date[$i + 1], 0, 2);
                $secondyear = substr($data_date[$i + 1], -4);
                $temp2 = $data_date[$i + 1];
                $first = strrpos($temp2, '/', -6);
                $last = strrpos($temp2, '/');
                $secondmonth = substr($temp2, 0, $first);
                //check the date, if same, then sum up.
                if ($firstmonth == $secondmonth && $firstyear == $secondyear) {
                    $counts_density++;
                    $monthly_temp[] = (float) $data_para[$i + 1];
                    //if it's the last day, stop the loop here.
                    if ($i == (count($data_date) - 2)) {
                        $median = $this->calculate_median($monthly_temp);
                        $monthly_median[] = array('start_time' => $start_time, 'density' => ($counts_density + 1), 'value' => $median);
                    }
                }
                //if not same month,
                //record the monthly average, continue to next month;
                else {
                    $median = $this->calculate_median($monthly_temp);
                    $monthly_median[] = array('start_time' => $start_time, 'density' => ($counts_density + 1), 'value' => $median);
                    //next month value
                    $start_time = $data_date[$i + 1];
                    $counts_density = 0;
                    $monthly_temp = array();
                    $monthly_temp[] = (float) $data_para[$i + 1];
                    //if the ($i+1) date is the last value, record the value.
                    if ($i == (count($data_date) - 2)) {
                        //$median = calculate_median($monthly_temp);
                        $monthly_median[] = array('start_time' => $start_time, 'density' => ($counts_density + 1), 'value' => $data_para[$i + 1]);
                    }
                }
            }
            return $monthly_median;
        }
        //yearly average
        if ($by == 2) {
            $counts_density = 0;
            $start_time = $data_date[0];
            $yearly_median = array();
            $yearly_temp = array();
            $yearly_temp[] = $data_para[0];
            if (count($data_date) == 1) {
                $yearly_median[] = array('start_time' => $start_time, 'density' => 1, 'value' => $data_para[0]);
            }
            for ($i = 0; $i < count($data_date) - 1; $i++) {
                $firstyear = substr($start_time, -4);
                $secondyear = substr($data_date[$i + 1], -4);

                if ($firstyear == $secondyear) {
                    $counts_density++;
                    $yearly_temp[] = (float) $data_para[$i + 1];
                    if ($i == (count($data_date) - 2)) {
                        $median = $this->calculate_median($yearly_temp);
                        $yearly_median[] = array('start_time' => $start_time, 'density' => ($counts_density + 1), 'value' => $median);
                    }
                }
                //record the yearly average, continue to next year;
                else {
                    $median = $this->calculate_median($yearly_temp);
                    $yearly_median[] = array('start_time' => $start_time, 'density' => ($counts_density + 1), 'value' => $median);
                    //update the value;
                    $start_time = $data_date[$i + 1];
                    $counts_density = 0;
                    $sum = (float) $data_para[$i + 1];
                    if ($i == (count($data_date) - 2)) {
                        $yearly_median[] = array('start_time' => $start_time, 'density' => ($counts_density + 1), 'value' => $data_para[$i + 1]);
                    }
                }
            }
            return $yearly_median;
        }
        //seasonly median
        if ($by == 3) {
            $counts_density = 0;
            $sum = (float) $data_para[0];
            $average = 0;
            $start_time = $data_date[0];
            $firstyear = substr($start_time, -4);
            //$firstmonth = substr($start_time, 0, 2);
            $temp2 = $start_time;
            $first = strrpos($temp2, '/', -6);
            $last = strrpos($temp2, '/');
            $firstmonth = substr($temp2, 0, $first);

            $semeananonally_median = array();
            $spring = array();
            $summer = array();
            $fall = array();
            $winter = array();
            $nextwinter = array();
            if (count($data_date) == 1) {
                if ($firstmonth == 12 || $firstmonth == 1 || $firstmonth == 2) {
                    $wi = $data_para[0];
                    $sp = "";
                    $su = "";
                    $fa = "";
                    if ($firstyear == 12)
                        $firstyear++;
                }
                if ($firstmonth == 3 || $firstmonth == 4 || $firstmonth == 5) {
                    $wi = "";
                    $sp = $data_para[0];
                    $su = "";
                    $fa = "";
                }
                if ($firstmonth == 6 || $firstmonth == 7 || $firstmonth == 8) {
                    $wi = "";
                    $sp = "";
                    $su = $data_para[0];
                    $fa = "";
                }
                if ($firstmonth == 9 || $firstmonth == 10 || $firstmonth == 11) {
                    $wi = "";
                    $sp = "";
                    $su = "";
                    $fa = $data_para[0];
                }
                if ($wi == null) {
                    $dwi = 0;
                } else {
                    $dwi = 1;
                }
                if ($su == null) {
                    $dsu = 0;
                } else {
                    $dsu = 1;
                }
                if ($sp == null) {
                    $dsp = 0;
                } else {
                    $dsp = 1;
                }
                if ($fa == null) {
                    $dfa = 0;
                } else {
                    $dfa = 1;
                }
                $seanonally_median[] = array('start_time' => $firstyear, 'winter' => $wi,
                    'spring' => $sp, 'summer' => $su, 'fall' => $fa, 'dwinter' => $dwi, 'dspring' => $dsp, 'dsummer' => $dsu, 'dfall' => $dfa);
                return $seanonally_median;
            }
            for ($i = 0; $i < count($data_date); $i++) {
                $firstyear = substr($start_time, -4);
                $secondyear = substr($data_date[$i], -4);
                //$firstmonth = substr($start_time, 0, 2);
                $temp2 = $start_time;
                $first = strrpos($temp2, '/', -6);
                $last = strrpos($temp2, '/');
                $firstmonth = substr($temp2, 0, $first);
                //$secondmonth = substr($data_date[$i], 0, 2);
                $temp2 = $data_date[$i];
                $first = strrpos($temp2, '/', -6);
                $last = strrpos($temp2, '/');
                $secondmonth = substr($temp2, 0, $first);

                if ($firstyear == $secondyear) {

                    if ($secondmonth == '12') {
                        $nextwinter[] = $data_para[$i];
                    } else {
                        //$spring+=$nextspring;
                        if ($secondmonth == '01' || $secondmonth == '02') {
                            $winter[] = (float) $data_para[$i];
                        }
                        //count the 3, 4, 5 into first year's summer
                        else if ($secondmonth == '03' || $secondmonth == '04' || $secondmonth == '05') {
                            $spring[] = (float) $data_para[$i];
                        }
                        //count the 6,7,8 into the first year's fall
                        else if ($secondmonth == '06' || $secondmonth == '07' || $secondmonth == '08') {
                            $summer[] = (float) $data_para[$i];
                        }
                        //count the 9, 10, 11 into the first year's winter
                        else if ($secondmonth == '09' || $secondmonth == '10' || $secondmonth == '11') {
                            $fall[] = (float) $data_para[$i];
                        }
                    }
                    if ($i == count($data_date) - 1) {
                        $seanonally_median[] = array('start_time' => $firstyear, 'winter' => $this->calculate_median($winter),
                            'spring' => $this->calculate_median($spring), 'summer' => $this->calculate_median($summer), 'fall' => $this->calculate_median($fall), 'dwinter' => count($winter), 'dspring' => count($spring), 'dsummer' => count($summer), 'dfall' => count($fall));
                    }
                } else if ($firstyear == $secondyear - 1) {
                    //$spring=array_merge($spring,$nextspring);
                    //$nextspring = array();
                    $seanonally_median[] = array('start_time' => $firstyear, 'winter' => $this->calculate_median($winter),
                        'spring' => $this->calculate_median($spring), 'summer' => $this->calculate_median($summer), 'fall' => $this->calculate_median($fall), 'dwinter' => count($winter), 'dspring' => count($spring), 'dsummer' => count($summer), 'dfall' => count($fall));
                    $winter = $nextwinter;
                    $nextwinter = array();
                    $spring = array();
                    $summer = array();
                    $fall = array();
                    if ($secondmonth == '12') {
                        $nextwinter[] = $data_para[$i];
                    } else {
                        //$spring+=$nextspring;
                        if ($secondmonth == '01' || $secondmonth == '02') {
                            $winter[] = (float) $data_para[$i];
                        }
                        //count the 3, 4, 5 into first year's summer
                        else if ($secondmonth == '03' || $secondmonth == '04' || $secondmonth == '05') {
                            $spring[] = (float) $data_para[$i];
                        }
                        //count the 6,7,8 into the first year's fall
                        else if ($secondmonth == '06' || $secondmonth == '07' || $secondmonth == '08') {
                            $summer[] = (float) $data_para[$i];
                        }
                        //count the 9, 10, 11 into the first year's winter
                        else if ($secondmonth == '09' || $secondmonth == '10' || $secondmonth == '11') {
                            $fall[] = (float) $data_para[$i];
                        }
                    }
                    $start_time = $data_date[$i];
                } else if ($firstyear < $secondyear - 1) {
                    $seanonally_median[] = array('start_time' => $firstyear, 'winter' => $this->calculate_median($winter),
                        'spring' => $this->calculate_median($spring), 'summer' => $this->calculate_median($summer), 'fall' => $this->calculate_median($fall), 'dwinter' => count($winter), 'dspring' => count($spring), 'dsummer' => count($summer), 'dfall' => count($fall));
                    $winter = $nextwinter;
                    if ($winter != NULL) {
                        $seanonally_median[] = array('start_time' => $firstyear + 1, 'winter' => $this->calculate_median($winter),
                            'spring' => NULL, 'summer' => NULL, 'fall' => NULL, 'dwinter' => count($winter), 'dspring' => 0, 'dsummer' => 0, 'dfall' => 0);
                    }
                    $start_time = $data_date[$i];
                    $winter = array();
                    $spring = array();
                    $summer = array();
                    $fall = array();
                    if ($secondmonth == '12') {
                        $nextwinter[] = $data_para[$i];
                    } else {
                        //$spring+=$nextspring;
                        if ($secondmonth == '01' || $secondmonth == '02') {
                            $winter[] = (float) $data_para[$i];
                        }
                        //count the 3, 4, 5 into first year's summer
                        else if ($secondmonth == '03' || $secondmonth == '04' || $secondmonth == '05') {
                            $spring[] = (float) $data_para[$i];
                        }
                        //count the 6,7,8 into the first year's fall
                        else if ($secondmonth == '06' || $secondmonth == '07' || $secondmonth == '08') {
                            $summer[] = (float) $data_para[$i];
                        }
                        //count the 9, 10, 11 into the first year's winter
                        else if ($secondmonth == '09' || $secondmonth == '10' || $secondmonth == '11') {
                            $fall[] = (float) $data_para[$i];
                        }
                    }
                }
            }
            return $seanonally_median;
        }
    }

    function sta_variance($result, $by) {
        $column_names = array_keys($result[0]);
        $column_date = $column_names[4];
        $column_para = $column_names[7];
        //get the column values
        $data_date = array();
        $data_para = array();
        foreach ($result as $row) {
            $data_date[] = $row[$column_date];
            $data_para[] = $row[$column_para];
        }
        //monthly variance
        if ($by == 1) {
            $counts_density = 0;
            $sum = (float) $data_para[0];
            $average = 0;
            $start_time = $data_date[0];
            $monthly_variance = array();
            $part = array();
            $part[] = $data_para[0];
            if (count($data_date) == 1) {
                $monthly_variance[] = array('start_time' => $start_time, 'density' => 1, 'value' => $sum);
            }
            for ($i = 0; $i < count($data_date) - 1; $i++) {
                //$firstmonth = substr($start_time, 0, 2);
                $temp2 = $start_time;
                $first = strrpos($temp2, '/', -6);
                $last = strrpos($temp2, '/');
                $firstmonth = substr($temp2, 0, $first);
                $temp2 = $data_date[$i + 1];
                $first = strrpos($temp2, '/', -6);
                $last = strrpos($temp2, '/');
                $secondmonth = substr($temp2, 0, $first);
                $firstyear = substr($start_time, -4);
                //$secondmonth = substr($data_date[$i + 1], 0, 2);
                $secondyear = substr($data_date[$i + 1], -4);
                //check the date, if same, then sum up.
                if ($firstmonth == $secondmonth && $firstyear == $secondyear) {
                    $counts_density++;
                    $sum+=(float) $data_para[$i + 1];
                    $part[] = $data_para[$i + 1];
                    //if it's the last day, stop the loop here.
                    if ($i == (count($data_date) - 2)) {
                        $average = (float) $sum / ($counts_density + 1);
                        $variance = $this->calculate_variance($part, $average);
                        $monthly_variance[] = array('start_time' => $start_time, 'density' => ($counts_density + 1), 'value' => $variance);
                    }
                }
                //if not same month,
                //record the monthly average, continue to next month;
                else {
                    $average = (float) $sum / ($counts_density + 1);
                    $variance = $this->calculate_variance($part, $average);
                    $monthly_variance[] = array('start_time' => $start_time, 'density' => ($counts_density + 1), 'value' => $variance);
                    //next month value
                    $part = array();
                    $start_time = $data_date[$i + 1];
                    $part[] = $data_para[$i + 1];
                    $counts_density = 0;
                    $sum = (float) $data_para[$i + 1];
                    //if the ($i+1) date is the last value, record the value.
                    if ($i == (count($data_date) - 2)) {
                        $variance = 0;
                        $monthly_variance[] = array('start_time' => $start_time, 'density' => ($counts_density + 1), 'value' => $variance);
                    }
                }
            }
            return $monthly_variance;
        }
        //yearly variance
        if ($by == 2) {
            $counts_density = 0;
            $sum = (float) $data_para[0];
            $average = 0;
            $start_time = $data_date[0];
            $yearly_variance = array();
            $part = array();
            $part[] = $data_para[0];
            if (count($data_date) == 1) {
                $yearly_mean[] = array('start_time' => $start_time, 'density' => 1, 'value' => $data_para[0]);
            }
            for ($i = 0; $i < count($data_date) - 1; $i++) {
                $firstyear = substr($start_time, -4);
                $secondyear = substr($data_date[$i + 1], -4);

                if ($firstyear == $secondyear) {
                    $counts_density++;
                    $sum+=(float) $data_para[$i + 1];
                    $part[] = $data_para[$i + 1];
                    if ($i == (count($data_date) - 2)) {
                        $average = (float) $sum / ($counts_density + 1);
                        $variance = $this->calculate_variance($part, $average);
                        $yearly_variance[] = array('start_time' => $start_time, 'density' => ($counts_density + 1), 'value' => $variance);
                    }
                }
                //record the yearly average, continue to next year;
                else {
                    $average = (float) $sum / ($counts_density + 1);
                    $variance = $this->calculate_variance($part, $average);
                    $yearly_variance[] = array('start_time' => $start_time, 'density' => ($counts_density + 1), 'value' => $variance);
                    //next month value
                    $part = array();
                    //update the value;
                    $start_time = $data_date[$i + 1];
                    $counts_density = 0;
                    $part[] = $data_para[$i + 1];
                    $sum = (float) $data_para[$i + 1];
                    if ($i == (count($data_date) - 2)) {
                        $variance = 0;
                        $yearly_variance[] = array('start_time' => $start_time, 'density' => ($counts_density + 1), 'value' => $variance);
                    }
                }
            }
            return $yearly_variance;
        }
        //seasonly average
        if ($by == 3) {
            $counts_density = 0;
            $sum = (float) $data_para[0];
            $average = 0;
            $start_time = $data_date[0];
            $firstyear = substr($start_time, -4);
            //$firstmonth = substr($start_time, 0, 2);
            $temp2 = $start_time;
            $first = strrpos($temp2, '/', -6);
            $last = strrpos($temp2, '/');
            $firstmonth = substr($temp2, 0, $first);
            $seanonally_variance = array();
            $spring = array();
            $summer = array();
            $fall = array();
            $winter = array();
            $nextwinter = array();
            if (count($data_date) == 1) {
                if ($firstmonth == 12 || $firstmonth == 1 || $firstmonth == 2) {
                    $wi = $data_para[0];
                    $sp = "";
                    $su = "";
                    $fa = "";
                    if ($firstyear == 12)
                        $firstyear++;
                }
                if ($firstmonth == 3 || $firstmonth == 4 || $firstmonth == 5) {
                    $wi = "";
                    $sp = $data_para[0];
                    $su = "";
                    $fa = "";
                }
                if ($firstmonth == 6 || $firstmonth == 7 || $firstmonth == 8) {
                    $wi = "";
                    $sp = "";
                    $su = $data_para[0];
                    $fa = "";
                }
                if ($firstmonth == 9 || $firstmonth == 10 || $firstmonth == 11) {
                    $wi = "";
                    $sp = "";
                    $su = "";
                    $fa = $data_para[0];
                }
                if ($wi == null) {
                    $dwi = 0;
                } else {
                    $dwi = 1;
                }
                if ($su == null) {
                    $dsu = 0;
                } else {
                    $dsu = 1;
                }
                if ($sp == null) {
                    $dsp = 0;
                } else {
                    $dsp = 1;
                }
                if ($fa == null) {
                    $dfa = 0;
                } else {
                    $dfa = 1;
                }
                $seanonally_variance[] = array('start_time' => $firstyear, 'winter' => $wi,
                    'spring' => $sp, 'summer' => $su, 'fall' => $fa, 'dwinter' => $dwi, 'dspring' => $dsp, 'dsummer' => $dsu, 'dfall' => $dfa);
                return $seanonally_variance;
            }
            for ($i = 0; $i < count($data_date); $i++) {
                $firstyear = substr($start_time, -4);
                $secondyear = substr($data_date[$i], -4);
                //$firstmonth = substr($start_time, 0, 2);
                $temp2 = $start_time;
                $first = strrpos($temp2, '/', -6);
                $last = strrpos($temp2, '/');
                $firstmonth = substr($temp2, 0, $first);
                //$secondmonth = substr($data_date[$i], 0, 2);
                $temp2 = $data_date[$i];
                $first = strrpos($temp2, '/', -6);
                $last = strrpos($temp2, '/');
                $secondmonth = substr($temp2, 0, $first);
                if ($firstyear == $secondyear) {

                    if ($secondmonth == '12') {
                        $nextwinter[] = $data_para[$i];
                    } else {
                        //$spring+=$nextspring;
                        if ($secondmonth == '01' || $secondmonth == '02') {
                            $winter[] = (float) $data_para[$i];
                        }
                        //count the 3, 4, 5 into first year's summer
                        else if ($secondmonth == '03' || $secondmonth == '04' || $secondmonth == '05') {
                            $spring[] = (float) $data_para[$i];
                        }
                        //count the 6,7,8 into the first year's fall
                        else if ($secondmonth == '06' || $secondmonth == '07' || $secondmonth == '08') {
                            $summer[] = (float) $data_para[$i];
                        }
                        //count the 9, 10, 11 into the first year's winter
                        else if ($secondmonth == '09' || $secondmonth == '10' || $secondmonth == '11') {
                            $fall[] = (float) $data_para[$i];
                        }
                    }
                    if ($i == count($data_date) - 1) {
                        $seanonally_variance[] = array('start_time' => $firstyear, 'winter' => $this->single_calculate_variance($winter),
                            'spring' => $this->single_calculate_variance($spring), 'summer' => $this->single_calculate_variance($summer), 'fall' => $this->single_calculate_variance($fall), 'dwinter' => count($winter), 'dspring' => count($spring), 'dsummer' => count($summer), 'dfall' => count($fall));
                    }
                } else if ($firstyear == $secondyear - 1) {
                    //$spring=array_merge($spring,$nextspring);
                    //$nextspring = array();
                    $seanonally_variance[] = array('start_time' => $firstyear, 'winter' => $this->single_calculate_variance($winter),
                        'spring' => $this->single_calculate_variance($spring), 'summer' => $this->single_calculate_variance($summer), 'fall' => $this->single_calculate_variance($fall), 'dwinter' => count($winter), 'dspring' => count($spring), 'dsummer' => count($summer), 'dfall' => count($fall));
                    $winter = $nextwinter;
                    $nextwinter = array();
                    $spring = array();
                    $summer = array();
                    $fall = array();
                    if ($secondmonth == '12') {
                        $nextwinter[] = $data_para[$i];
                    } else {
                        //$spring+=$nextspring;
                        if ($secondmonth == '01' || $secondmonth == '02') {
                            $winter[] = (float) $data_para[$i];
                        }
                        //count the 3, 4, 5 into first year's summer
                        else if ($secondmonth == '03' || $secondmonth == '04' || $secondmonth == '05') {
                            $spring[] = (float) $data_para[$i];
                        }
                        //count the 6,7,8 into the first year's fall
                        else if ($secondmonth == '06' || $secondmonth == '07' || $secondmonth == '08') {
                            $summer[] = (float) $data_para[$i];
                        }
                        //count the 9, 10, 11 into the first year's winter
                        else if ($secondmonth == '09' || $secondmonth == '10' || $secondmonth == '11') {
                            $fall[] = (float) $data_para[$i];
                        }
                    }
                    $start_time = $data_date[$i];
                } else if ($firstyear < $secondyear - 1) {
                    $seanonally_variance[] = array('start_time' => $firstyear, 'winter' => $this->single_calculate_variance($winter),
                        'spring' => $this->single_calculate_variance($spring), 'summer' => $this->single_calculate_variance($summer), 'fall' => $this->single_calculate_variance($fall), 'dwinter' => count($winter), 'dspring' => count($spring), 'dsummer' => count($summer), 'dfall' => count($fall));
                    $winter = $nextwinter;
                    if ($winter != NULL) {
                        $seanonally_variance[] = array('start_time' => $firstyear + 1, 'winter' => $this->single_calculate_variance($winter),
                            'spring' => 0, 'summer' => 0, 'fall' => 0, 'dwinter' => count($winter), 'dspring' => 0, 'dsummer' => 0, 'dfall' => 0);
                    }
                    $start_time = $data_date[$i];
                    $winter = array();
                    $spring = array();
                    $summer = array();
                    $fall = array();
                    if ($secondmonth == '12') {
                        $nextwinter[] = $data_para[$i];
                    } else {
                        //$spring+=$nextspring;
                        if ($secondmonth == '01' || $secondmonth == '02') {
                            $winter[] = (float) $data_para[$i];
                        }
                        //count the 3, 4, 5 into first year's summer
                        else if ($secondmonth == '03' || $secondmonth == '04' || $secondmonth == '05') {
                            $spring[] = (float) $data_para[$i];
                        }
                        //count the 6,7,8 into the first year's fall
                        else if ($secondmonth == '06' || $secondmonth == '07' || $secondmonth == '08') {
                            $summer[] = (float) $data_para[$i];
                        }
                        //count the 9, 10, 11 into the first year's winter
                        else if ($secondmonth == '09' || $secondmonth == '10' || $secondmonth == '11') {
                            $fall[] = (float) $data_para[$i];
                        }
                    }
                }
            }
            return $seanonally_variance;
        }
    }

    function sta_max($result, $by) {
        $column_names = array_keys($result[0]);
        $column_date = $column_names[4];
        $column_para = $column_names[7];
        //get the column values
        $data_date = array();
        $data_para = array();
        foreach ($result as $row) {
            $data_date[] = $row[$column_date];
            $data_para[] = $row[$column_para];
        }
        //monthly variance
        if ($by == 1) {
            $counts_density = 0;
            $start_time = $data_date[0];
            $monthly_max = array();
            $part = array();
            $part[] = $data_para[0];
            if (count($data_date) == 1) {
                $monthly_max[] = array('start_time' => $start_time, 'density' => 1, 'value' => $data_para[0]);
            }
            for ($i = 0; $i < count($data_date) - 1; $i++) {
                //$firstmonth = substr($start_time, 0, 2);
                $temp2 = $start_time;
                $first = strrpos($temp2, '/', -6);
                $last = strrpos($temp2, '/');
                $firstmonth = substr($temp2, 0, $first);
                $temp2 = $data_date[$i + 1];
                $first = strrpos($temp2, '/', -6);
                $last = strrpos($temp2, '/');
                $secondmonth = substr($temp2, 0, $first);
                $firstyear = substr($start_time, -4);
                //$secondmonth = substr($data_date[$i + 1], 0, 2);
                $secondyear = substr($data_date[$i + 1], -4);
                //check the date, if same, then sum up.
                if ($firstmonth == $secondmonth && $firstyear == $secondyear) {
                    $counts_density++;
                    $part[] = $data_para[$i + 1];
                    //if it's the last day, stop the loop here.
                    if ($i == (count($data_date) - 2)) {
                        //$partsorted=sort($part);
                        //$max=$partsorted[count($partsorted)-1];
                        sort($part);
                        $max = $part[count($part) - 1];
                        $monthly_max[] = array('start_time' => $start_time, 'density' => ($counts_density + 1), 'value' => $max);
                    }
                }
                //if not same month,
                //record the monthly average, continue to next month;
                else {
                    sort($part);
                    $max = $part[count($part) - 1];
                    $monthly_max[] = array('start_time' => $start_time, 'density' => ($counts_density + 1), 'value' => $max);
                    //next month value
                    $part = array();
                    $start_time = $data_date[$i + 1];
                    $part[] = $data_para[$i + 1];
                    $counts_density = 0;
                    //if the ($i+1) date is the last value, record the value.
                    if ($i == (count($data_date) - 2)) {
                        //$variance = 0;
                        $monthly_max[] = array('start_time' => $start_time, 'density' => ($counts_density + 1), 'value' => $data_para[$i + 1]);
                    }
                }
            }
            return $monthly_max;
        }
        if ($by == 2) {
            $counts_density = 0;
            $start_time = $data_date[0];
            $yearly_max = array();
            $part = array();
            $part[] = $data_para[0];
            if (count($data_date) == 1) {
                $yearly_max[] = array('start_time' => $start_time, 'density' => 1, 'value' => $data_para[0]);
            }
            for ($i = 0; $i < count($data_date) - 1; $i++) {
                $firstyear = substr($start_time, -4);
                $secondyear = substr($data_date[$i + 1], -4);

                if ($firstyear == $secondyear) {
                    $counts_density++;
                    $part[] = $data_para[$i + 1];
                    if ($i == (count($data_date) - 2)) {
                        sort($part);
                        $max = $part[count($part) - 1];
                        $yearly_max[] = array('start_time' => $start_time, 'density' => ($counts_density + 1), 'value' => $max);
                    }
                }
                //record the yearly average, continue to next year;
                else {
                    sort($part);
                    $max = $part[count($part) - 1];
                    $yearly_max[] = array('start_time' => $start_time, 'density' => ($counts_density + 1), 'value' => $max);
                    //next month value
                    $part = array();
                    //update the value;
                    $start_time = $data_date[$i + 1];
                    $counts_density = 0;
                    $part[] = $data_para[$i + 1];
                    if ($i == (count($data_date) - 2)) {
                        //$variance = 0;
                        $yearly_max[] = array('start_time' => $start_time, 'density' => ($counts_density + 1), 'value' => $data_para[$i + 1]);
                    }
                }
            }
            return $yearly_max;
        }
        if ($by == 3) {
            $counts_density = 0;

            $start_time = $data_date[0];
            $firstyear = substr($start_time, -4);
            //$firstmonth = substr($start_time, 0, 2);
            $temp2 = $start_time;
            $first = strrpos($temp2, '/', -6);
            $last = strrpos($temp2, '/');
            $firstmonth = substr($temp2, 0, $first);
            $seanonally_max = array();
            $spring = array();
            $summer = array();
            $fall = array();
            $winter = array();
            $nextwinter = array();
            if (count($data_date) == 1) {
                if ($firstmonth == 12 || $firstmonth == 1 || $firstmonth == 2) {
                    $wi = $data_para[0];
                    $sp = "";
                    $su = "";
                    $fa = "";
                    if ($firstyear == 12)
                        $firstyear++;
                }
                if ($firstmonth == 3 || $firstmonth == 4 || $firstmonth == 5) {
                    $wi = "";
                    $sp = $data_para[0];
                    $su = "";
                    $fa = "";
                }
                if ($firstmonth == 6 || $firstmonth == 7 || $firstmonth == 8) {
                    $wi = "";
                    $sp = "";
                    $su = $data_para[0];
                    $fa = "";
                }
                if ($firstmonth == 9 || $firstmonth == 10 || $firstmonth == 11) {
                    $wi = "";
                    $sp = "";
                    $su = "";
                    $fa = $data_para[0];
                }
                if ($wi == null) {
                    $dwi = 0;
                } else {
                    $dwi = 1;
                }
                if ($su == null) {
                    $dsu = 0;
                } else {
                    $dsu = 1;
                }
                if ($sp == null) {
                    $dsp = 0;
                } else {
                    $dsp = 1;
                }
                if ($fa == null) {
                    $dfa = 0;
                } else {
                    $dfa = 1;
                }
                $seanonally_max[] = array('start_time' => $firstyear, 'winter' => $wi,
                    'spring' => $sp, 'summer' => $su, 'fall' => $fa, 'dwinter' => $dwi, 'dspring' => $dsp, 'dsummer' => $dsu, 'dfall' => $dfa);
                return $seanonally_max;
            }
            for ($i = 0; $i < count($data_date); $i++) {
                $firstyear = substr($start_time, -4);
                $secondyear = substr($data_date[$i], -4);
                //$firstmonth = substr($start_time, 0, 2);
                $temp2 = $start_time;
                $first = strrpos($temp2, '/', -6);
                $last = strrpos($temp2, '/');
                $firstmonth = substr($temp2, 0, $first);
                //$secondmonth = substr($data_date[$i], 0, 2);
                $temp2 = $data_date[$i];
                $first = strrpos($temp2, '/', -6);
                $last = strrpos($temp2, '/');
                $secondmonth = substr($temp2, 0, $first);
                if ($firstyear == $secondyear) {

                    if ($secondmonth == '12') {
                        $nextwinter[] = $data_para[$i];
                    } else {
                        //$spring+=$nextspring;
                        if ($secondmonth == '01' || $secondmonth == '02') {
                            $winter[] = (float) $data_para[$i];
                        }
                        //count the 3, 4, 5 into first year's summer
                        else if ($secondmonth == '03' || $secondmonth == '04' || $secondmonth == '05') {
                            $spring[] = (float) $data_para[$i];
                        }
                        //count the 6,7,8 into the first year's fall
                        else if ($secondmonth == '06' || $secondmonth == '07' || $secondmonth == '08') {
                            $summer[] = (float) $data_para[$i];
                        }
                        //count the 9, 10, 11 into the first year's winter
                        else if ($secondmonth == '09' || $secondmonth == '10' || $secondmonth == '11') {
                            $fall[] = (float) $data_para[$i];
                        }
                    }
                    if ($i == count($data_date) - 1) {
                        if (count($winter) > 0) {
                            sort($winter);
                            $winter_max = $winter[count($winter) - 1];
                        } else {
                            $winter_max = "";
                        }
                        if (count($fall) > 0) {
                            sort($fall);
                            $fall_max = $fall[count($fall) - 1];
                        } else {
                            $fall_max = "";
                        }
                        if (count($summer) > 0) {
                            sort($summer);
                            $summer_max = $summer[count($summer) - 1];
                        } else {
                            $summer_max = "";
                        }
                        if (count($spring) > 0) {
                            sort($spring);
                            $spring_max = $spring[count($spring) - 1];
                        } else {
                            $spring_max = "";
                        }
                        $seanonally_max[] = array('start_time' => $firstyear, 'winter' => $winter_max,
                            'spring' => $spring_max, 'summer' => $summer_max, 'fall' => $fall_max, 'dwinter' => count($winter), 'dspring' => count($spring), 'dsummer' => count($summer), 'dfall' => count($fall));
                    }
                } else if ($firstyear == $secondyear - 1) {
                    if (count($winter) > 0) {
                        sort($winter);
                        $winter_max = $winter[count($winter) - 1];
                    } else {
                        $winter_max = "";
                    }
                    if (count($fall) > 0) {
                        sort($fall);
                        $fall_max = $fall[count($fall) - 1];
                    } else {
                        $fall_max = "";
                    }
                    if (count($summer) > 0) {
                        sort($summer);
                        $summer_max = $summer[count($summer) - 1];
                    } else {
                        $summer_max = "";
                    }
                    if (count($spring) > 0) {
                        sort($spring);
                        $spring_max = $spring[count($spring) - 1];
                    } else {
                        $spring_max = "";
                    }
                    $seanonally_max[] = array('start_time' => $firstyear, 'winter' => $winter_max,
                        'spring' => $spring_max, 'summer' => $summer_max, 'fall' => $fall_max, 'dwinter' => count($winter), 'dspring' => count($spring), 'dsummer' => count($summer), 'dfall' => count($fall));

                    $winter = $nextwinter;
                    $nextwinter = array();
                    $spring = array();
                    $summer = array();
                    $fall = array();
                    if ($secondmonth == '12') {
                        $nextwinter[] = $data_para[$i];
                    } else {
                        //$spring+=$nextspring;
                        if ($secondmonth == '01' || $secondmonth == '02') {
                            $winter[] = (float) $data_para[$i];
                        }
                        //count the 3, 4, 5 into first year's summer
                        else if ($secondmonth == '03' || $secondmonth == '04' || $secondmonth == '05') {
                            $spring[] = (float) $data_para[$i];
                        }
                        //count the 6,7,8 into the first year's fall
                        else if ($secondmonth == '06' || $secondmonth == '07' || $secondmonth == '08') {
                            $summer[] = (float) $data_para[$i];
                        }
                        //count the 9, 10, 11 into the first year's winter
                        else if ($secondmonth == '09' || $secondmonth == '10' || $secondmonth == '11') {
                            $fall[] = (float) $data_para[$i];
                        }
                    }
                    $start_time = $data_date[$i];
                } else if ($firstyear < $secondyear - 1) {

                    if (count($winter) > 0) {
                        sort($winter);
                        $winter_max = $winter[count($winter) - 1];
                    } else {
                        $winter_max = "";
                    }
                    if (count($fall) > 0) {
                        sort($fall);
                        $fall_max = $fall[count($fall) - 1];
                    } else {
                        $fall_max = "";
                    }
                    if (count($summer) > 0) {
                        sort($summer);
                        $summer_max = $summer[count($summer) - 1];
                    } else {
                        $summer_max = "";
                    }
                    if (count($spring) > 0) {
                        sort($spring);
                        $spring_max = $spring[count($spring) - 1];
                    } else {
                        $spring_max = "";
                    }
                    $seanonally_max[] = array('start_time' => $firstyear, 'winter' => $winter_max,
                        'spring' => $spring_max, 'summer' => $summer_max, 'fall' => $fall_max, 'dwinter' => count($winter), 'dspring' => count($spring), 'dsummer' => count($summer), 'dfall' => count($fall));
                    $winter = $nextwinter;
                    if ($winter != NULL) {

                        sort($winter);
                        $max = $winter[count($winter) - 1];
                        $seanonally_max[] = array('start_time' => $firstyear + 1, 'winter' => $max,
                            'spring' => 0, 'summer' => 0, 'fall' => 0, 'dwinter' => count($winter), 'dspring' => 0, 'dsummer' => 0, 'dfall' => 0);
                    }
                    $start_time = $data_date[$i];
                    $winter = array();
                    $spring = array();
                    $summer = array();
                    $fall = array();
                    if ($secondmonth == '12') {
                        $nextwinter[] = $data_para[$i];
                    } else {
                        //$spring+=$nextspring;
                        if ($secondmonth == '01' || $secondmonth == '02') {
                            $winter[] = (float) $data_para[$i];
                        }
                        //count the 3, 4, 5 into first year's summer
                        else if ($secondmonth == '03' || $secondmonth == '04' || $secondmonth == '05') {
                            $spring[] = (float) $data_para[$i];
                        }
                        //count the 6,7,8 into the first year's fall
                        else if ($secondmonth == '06' || $secondmonth == '07' || $secondmonth == '08') {
                            $summer[] = (float) $data_para[$i];
                        }
                        //count the 9, 10, 11 into the first year's winter
                        else if ($secondmonth == '09' || $secondmonth == '10' || $secondmonth == '11') {
                            $fall[] = (float) $data_para[$i];
                        }
                    }
                }
            }
            return $seanonally_max;
        }
    }

    function sta_min($result, $by) {
        $column_names = array_keys($result[0]);
        $column_date = $column_names[4];
        $column_para = $column_names[7];
        //get the column values
        $data_date = array();
        $data_para = array();
        foreach ($result as $row) {
            $data_date[] = $row[$column_date];
            $data_para[] = $row[$column_para];
        }
        //monthly variance
        if ($by == 1) {
            $counts_density = 0;
            $start_time = $data_date[0];
            $monthly_min = array();
            $part = array();
            $part[] = $data_para[0];
            if (count($data_date) == 1) {
                $monthly_min[] = array('start_time' => $start_time, 'density' => 1, 'value' => $data_para[0]);
            }
            for ($i = 0; $i < count($data_date) - 1; $i++) {
                //$firstmonth = substr($start_time, 0, 2);
                $temp2 = $start_time;
                $first = strrpos($temp2, '/', -6);
                $last = strrpos($temp2, '/');
                $firstmonth = substr($temp2, 0, $first);
                $temp2 = $data_date[$i + 1];
                $first = strrpos($temp2, '/', -6);
                $last = strrpos($temp2, '/');
                $secondmonth = substr($temp2, 0, $first);
                $firstyear = substr($start_time, -4);
                //$secondmonth = substr($data_date[$i + 1], 0, 2);
                $secondyear = substr($data_date[$i + 1], -4);
                //check the date, if same, then sum up.
                if ($firstmonth == $secondmonth && $firstyear == $secondyear) {
                    $counts_density++;
                    $part[] = $data_para[$i + 1];
                    //if it's the last day, stop the loop here.
                    if ($i == (count($data_date) - 2)) {
                        //$partsorted=sort($part);
                        //$min=$partsorted[0];
                        sort($part);
                        $min = $part[0];
                        //$average = (float) $sum / ($counts_density + 1);
                        //$variance = $this->calculate_variance($part, $average);
                        $monthly_min[] = array('start_time' => $start_time, 'density' => ($counts_density + 1), 'value' => $min);
                    }
                }
                //if not same month,
                //record the monthly average, continue to next month;
                else {
                    sort($part);
                    $min = $part[0];
                    $monthly_min[] = array('start_time' => $start_time, 'density' => ($counts_density + 1), 'value' => $min);
                    //next month value
                    $part = array();
                    $start_time = $data_date[$i + 1];
                    $part[] = $data_para[$i + 1];
                    $counts_density = 0;

                    //if the ($i+1) date is the last value, record the value.
                    if ($i == (count($data_date) - 2)) {
                        //$variance = 0;
                        $monthly_min[] = array('start_time' => $start_time, 'density' => ($counts_density + 1), 'value' => $data_para[$i + 1]);
                    }
                }
            }
            return $monthly_min;
        }
        //yearly min
        if ($by == 2) {
            $counts_density = 0;
            $start_time = $data_date[0];
            $yearly_min = array();
            $part = array();
            $part[] = $data_para[0];
            if (count($data_date) == 1) {
                $yearly_min[] = array('start_time' => $start_time, 'density' => 1, 'value' => $data_para[0]);
            }
            for ($i = 0; $i < count($data_date) - 1; $i++) {
                $firstyear = substr($start_time, -4);
                $secondyear = substr($data_date[$i + 1], -4);

                if ($firstyear == $secondyear) {
                    $counts_density++;
                    $part[] = $data_para[$i + 1];
                    if ($i == (count($data_date) - 2)) {
                        sort($part);
                        $min = $part[0];
                        $yearly_min[] = array('start_time' => $start_time, 'density' => ($counts_density + 1), 'value' => $min);
                    }
                }
                //record the yearly average, continue to next year;
                else {
                    sort($part);
                    $min = $part[0];
                    $yearly_min[] = array('start_time' => $start_time, 'density' => ($counts_density + 1), 'value' => $min);
                    //next month value
                    $part = array();
                    //update the value;
                    $start_time = $data_date[$i + 1];
                    $counts_density = 0;
                    $part[] = $data_para[$i + 1];
                    if ($i == (count($data_date) - 2)) {
                        //$variance = 0;
                        $yearly_min[] = array('start_time' => $start_time, 'density' => ($counts_density + 1), 'value' => $data_para[$i + 1]);
                    }
                }
            }
            return $yearly_min;
        }
        if ($by == 3) {
            $counts_density = 0;

            $start_time = $data_date[0];
            $firstyear = substr($start_time, -4);
            //$firstmonth = substr($start_time, 0, 2);
            $temp2 = $start_time;
            $first = strrpos($temp2, '/', -6);
            $last = strrpos($temp2, '/');
            $firstmonth = substr($temp2, 0, $first);
            $seanonally_min = array();
            $spring = array();
            $summer = array();
            $fall = array();
            $winter = array();
            $nextwinter = array();
            if (count($data_date) == 1) {
                if ($firstmonth == 12 || $firstmonth == 1 || $firstmonth == 2) {
                    $wi = $data_para[0];
                    $sp = "";
                    $su = "";
                    $fa = "";
                    if ($firstyear == 12)
                        $firstyear++;
                }
                if ($firstmonth == 3 || $firstmonth == 4 || $firstmonth == 5) {
                    $wi = "";
                    $sp = $data_para[0];
                    $su = "";
                    $fa = "";
                }
                if ($firstmonth == 6 || $firstmonth == 7 || $firstmonth == 8) {
                    $wi = "";
                    $sp = "";
                    $su = $data_para[0];
                    $fa = "";
                }
                if ($firstmonth == 9 || $firstmonth == 10 || $firstmonth == 11) {
                    $wi = "";
                    $sp = "";
                    $su = "";
                    $fa = $data_para[0];
                }
                if ($wi == null) {
                    $dwi = 0;
                } else {
                    $dwi = 1;
                }
                if ($su == null) {
                    $dsu = 0;
                } else {
                    $dsu = 1;
                }
                if ($sp == null) {
                    $dsp = 0;
                } else {
                    $dsp = 1;
                }
                if ($fa == null) {
                    $dfa = 0;
                } else {
                    $dfa = 1;
                }
                $seanonally_min[] = array('start_time' => $firstyear, 'winter' => $wi,
                    'spring' => $sp, 'summer' => $su, 'fall' => $fa, 'dwinter' => $dwi, 'dspring' => $dsp, 'dsummer' => $dsu, 'dfall' => $dfa);
                return $seanonally_min;
            }
            for ($i = 0; $i < count($data_date); $i++) {
                $firstyear = substr($start_time, -4);
                $secondyear = substr($data_date[$i], -4);
                //$firstmonth = substr($start_time, 0, 2);
                $temp2 = $start_time;
                $first = strrpos($temp2, '/', -6);
                $last = strrpos($temp2, '/');
                $firstmonth = substr($temp2, 0, $first);
                //$secondmonth = substr($data_date[$i], 0, 2);
                $temp2 = $data_date[$i];
                $first = strrpos($temp2, '/', -6);
                $last = strrpos($temp2, '/');
                $secondmonth = substr($temp2, 0, $first);
                if ($firstyear == $secondyear) {

                    if ($secondmonth == '12') {
                        $nextwinter[] = $data_para[$i];
                    } else {
                        //$spring+=$nextspring;
                        if ($secondmonth == '01' || $secondmonth == '02') {
                            $winter[] = (float) $data_para[$i];
                        }
                        //count the 3, 4, 5 into first year's summer
                        else if ($secondmonth == '03' || $secondmonth == '04' || $secondmonth == '05') {
                            $spring[] = (float) $data_para[$i];
                        }
                        //count the 6,7,8 into the first year's fall
                        else if ($secondmonth == '06' || $secondmonth == '07' || $secondmonth == '08') {
                            $summer[] = (float) $data_para[$i];
                        }
                        //count the 9, 10, 11 into the first year's winter
                        else if ($secondmonth == '09' || $secondmonth == '10' || $secondmonth == '11') {
                            $fall[] = (float) $data_para[$i];
                        }
                    }
                    if ($i == count($data_date) - 1) {
                        if (count($winter) >0) {
                            sort($winter);
                            $winter_min = $winter[0];
                        } else {
                            $winter_min = "";
                        }
                        if (count($fall) > 0) {
                            sort($fall);
                            $fall_min = $fall[0];
                        } else {
                            $fall_min = "";
                        }
                        if (count($summer) > 0) {
                            sort($summer);
                            $summer_min = $summer[0];
                        } else {
                            $summer_min = "";
                        }
                        if (count($spring) > 0) {
                            sort($spring);
                            $spring_min = $spring[0];
                        } else {
                            $spring_min = "";
                        }
                        $seanonally_min[] = array('start_time' => $firstyear, 'winter' => $winter_min,
                            'spring' => $spring_min, 'summer' => $summer_min, 'fall' => $fall_min, 'dwinter' => count($winter), 'dspring' => count($spring), 'dsummer' => count($summer), 'dfall' => count($fall));
                    }
                } else if ($firstyear == $secondyear - 1) {
                    if (count($winter) > 0) {
                        sort($winter);
                        $winter_min = $winter[0];
                    } else {
                        $winter_min = "";
                    }
                    if (count($fall) > 0) {
                        sort($fall);
                        $fall_min = $fall[0];
                    } else {
                        $fall_min = "";
                    }
                    if (count($summer) > 0) {
                        sort($summer);
                        $summer_min = $summer[0];
                    } else {
                        $summer_min = "";
                    }
                    if (count($spring) > 0) {
                        sort($spring);
                        $spring_min = $spring[0];
                    } else {
                        $spring_min = "";
                    }
                    $seanonally_min[] = array('start_time' => $firstyear, 'winter' => $winter_min,
                        'spring' => $spring_min, 'summer' => $summer_min, 'fall' => $fall_min, 'dwinter' => count($winter), 'dspring' => count($spring), 'dsummer' => count($summer), 'dfall' => count($fall));

                    $winter = $nextwinter;
                    $nextwinter = array();
                    $spring = array();
                    $summer = array();
                    $fall = array();
                    if ($secondmonth == '12') {
                        $nextwinter[] = $data_para[$i];
                    } else {
                        //$spring+=$nextspring;
                        if ($secondmonth == '01' || $secondmonth == '02') {
                            $winter[] = (float) $data_para[$i];
                        }
                        //count the 3, 4, 5 into first year's summer
                        else if ($secondmonth == '03' || $secondmonth == '04' || $secondmonth == '05') {
                            $spring[] = (float) $data_para[$i];
                        }
                        //count the 6,7,8 into the first year's fall
                        else if ($secondmonth == '06' || $secondmonth == '07' || $secondmonth == '08') {
                            $summer[] = (float) $data_para[$i];
                        }
                        //count the 9, 10, 11 into the first year's winter
                        else if ($secondmonth == '09' || $secondmonth == '10' || $secondmonth == '11') {
                            $fall[] = (float) $data_para[$i];
                        }
                    }
                    $start_time = $data_date[$i];
                } else if ($firstyear < $secondyear - 1) {
                    if (count($winter) > 0) {
                        sort($winter);
                        $winter_min = $winter[0];
                    } else {
                        $winter_min = "";
                    }
                    if (count($fall) > 0) {
                        sort($fall);
                        $fall_min = $fall[0];
                    } else {
                        $fall_min = "";
                    }
                    if (count($summer) > 0) {
                        sort($summer);
                        $summer_min = $summer[0];
                    } else {
                        $summer_min = "";
                    }
                    if (count($spring) > 0) {
                        sort($spring);
                        $spring_min = $spring[0];
                    } else {
                        $spring_min = "";
                    }
                    $seanonally_min[] = array('start_time' => $firstyear, 'winter' => $winter_min,
                        'spring' => $spring_min, 'summer' => $summer_min, 'fall' => $fall_min, 'dwinter' => count($winter), 'dspring' => count($spring), 'dsummer' => count($summer), 'dfall' => count($fall));
                    $winter = $nextwinter;
                    if ($winter != NULL) {
                        if (count($winter) > 0) {
                            sort($winter);
                            $min = $winter[0];
                        } else {
                            $min = "";
                        }
                        $seanonally_min[] = array('start_time' => $firstyear + 1, 'winter' => $min,
                            'spring' => 0, 'summer' => 0, 'fall' => 0, 'dwinter' => count($winter), 'dspring' => 0, 'dsummer' => 0, 'dfall' => 0);
                    }
                    $start_time = $data_date[$i];
                    $winter = array();
                    $spring = array();
                    $summer = array();
                    $fall = array();
                    if ($secondmonth == '12') {
                        $nextwinter[] = $data_para[$i];
                    } else {
                        //$spring+=$nextspring;
                        if ($secondmonth == '01' || $secondmonth == '02') {
                            $winter[] = (float) $data_para[$i];
                        }
                        //count the 3, 4, 5 into first year's summer
                        else if ($secondmonth == '03' || $secondmonth == '04' || $secondmonth == '05') {
                            $spring[] = (float) $data_para[$i];
                        }
                        //count the 6,7,8 into the first year's fall
                        else if ($secondmonth == '06' || $secondmonth == '07' || $secondmonth == '08') {
                            $summer[] = (float) $data_para[$i];
                        }
                        //count the 9, 10, 11 into the first year's winter
                        else if ($secondmonth == '09' || $secondmonth == '10' || $secondmonth == '11') {
                            $fall[] = (float) $data_para[$i];
                        }
                    }
                }
            }
            return $seanonally_min;
        }
    }

    function fsquare($x) {
        return $x * $x;
    }

    function fcube($x) {
        return $x * $x * $x;
    }

    function imax2($i, $j) {
        return ($i <= $j) ? $j : $i;
    }

    function imin2($i, $j) {
        return ($i >= $j) ? $j : $i;
    }

    function lowest(&$x, &$y, $n, $xs, $nleft, $nright, &$w, $userw, &$rw) {
        $range = $x[$n] - $x[1];
        //what if the range is zero?
        $h = $this->imax2($xs - $x[$nleft], $x[$nright] - $xs); //return the max value
        $h9 = 0.999 * $h;
        $h1 = 0.001 * $h;
        $a = 0;
        $j = $nleft;
        while ($j <= $n) {

            $w[$j] = 0;
            $r = abs($x[$j] - $xs);
            if ($r <= $h9) {
                if ($r <= $h1)
                    $w[$j] = 1;
                else
                    $w[$j] = $this->fcube(1 - $this->fcube($r / $h));
                if ($userw > 0)
                    $w[$j] *= $rw[$j];
                $a += $w[$j];
            }
            else if ($x[$j] > $xs)
                break;
            $j = $j + 1;
        }

        /* rightmost pt (may be greater */
        /* than nright because of ties) */

        $nrt = $j - 1;
        if ($a <= 0) {
            return null;
        } else {
            $ok = 1;
            for ($j = $nleft; $j <= $nrt; $j++)
                $w[$j] /= $a;
            if ($h > 0) {
                $a = 0;

                for ($j = $nleft; $j <= $nrt; $j++)
                    $a += $w[$j] * $x[$j];
                $b = $xs - $a;
                $c = 0;
                for ($j = $nleft; $j <= $nrt; $j++)
                    $c += $w[$j] * $this->fsquare($x[$j] - $a);
                if (sqrt($c) > 0.001 * $range) {
                    $b /= $c;
                    for ($j = $nleft; $j <= $nrt; $j++)
                        $w[$j] *= ( $b * ($x[$j] - $a) + 1);
                }
            }
            $ys = 0;
            for ($j = $nleft; $j <= $nrt; $j++)
                $ys += $w[$j] * $y[$j];
            return $ys;
        }
    }

    function lowess($x, $y, $f, $nsteps) {
        //$i, $iter, $j, $last, $m1, $m2, $nleft, $nright, $ns;

        $res = array();
        $rw = array();
        $ys = array();
        $ys[] = 0;
        $res[] = 0;
        $rw[] = 0;
        $n = count($x) - 1;
        $delta = 1 / 100 * ($x[$n] - $x[1]);
        //$alpha, $c1, $c9, $cmad, $cut, $d1, $d2, $denom, $r;

        if ($n < 2) {
            $ys[1] = $y[1];
            return $ys;
        }

        /* nleft, nright, last, etc. must all be shifted to get rid of these: */


        /* choose the nearby data to do the fitting for specific point */
        /* at least two, at most n points */

        $ns = $this->imax2(2, $this->imin2($n, intval($f * $n)));

        /* robustness iterations */

        $iter = 1;
        while ($iter <= $nsteps + 1) {
            $nleft = 1;
            $nright = $ns;
            $last = 0; /* index of prev estimated point */
            $i = 1;  /* index of current point */

            for (;;) {
                if ($nright < $n) {

                    /* move nleft,  nright to right */
                    /* if radius decreases */

                    $d1 = $x[$i] - $x[$nleft];
                    $d2 = $x[$nright + 1] - $x[$i];

                    if ($d1 > $d2) {
                        $nleft++;
                        $nright++;
                        continue;
                    }
                }

                /* fitted value at x[i] */
                if ($iter > 1)
                    $temp = $this->lowest($x, $y, $n, $x[$i],
                                    $nleft, $nright, $res, 1, $rw);
                else
                    $temp=$this->lowest($x, $y, $n, $x[$i],
                                    $nleft, $nright, $res, 0, $rw);
                if ($temp)
                    $ys[$i] = $temp;
                else
                    $ys[$i] = $y[$i];

                if ($last < $i - 1) {
                    $denom = $x[$i] - $x[$last];

                    for ($j = $last + 1; $j < $i; $j++) {
                        $alpha = ($x[$j] - $x[$last]) / $denom;
                        $ys[$j] = $alpha * $ys[$i] + (1 - $alpha) * $ys[$last];
                    }
                }

                /* last point actually estimated */
                $last = $i;

                /* x coord of close points */
                $cut = $x[$last] + $delta;
                for ($i = $last + 1; $i <= $n; $i++) {
                    if ($x[$i] > $cut)
                        break;
                    if ($x[$i] == $x[$last]) {
                        $ys[$i] = $ys[$last];
                        $last = $i;
                    }
                }
                $i = $this->imax2($last + 1, $i - 1);
                if ($last >= $n)
                    break;
            }
            /* residuals */
            for ($i = 0; $i < $n; $i++)
                $res[$i + 1] = $y[$i + 1] - $ys[$i + 1];

            /* compute robustness weights */
            /* except last time */

            if ($iter > $nsteps)
                break;

            for ($i = 0; $i < $n; $i++)
                $rw[$i + 1] = abs($res[$i + 1]);

            /* Compute   cmad := 6 * median(rw[], n)  ---- */
            $rw_copy = $rw;
            array_shift($rw_copy);
            $cmad = 6 * $this->calculate_median($rw_copy);

            $c9 = 0.999 * $cmad;
            $c1 = 0.001 * $cmad;
            for ($i = 0; $i < $n; $i++) {
                $r = abs($res[$i + 1]);
                if ($r <= $c1)
                    $rw[$i + 1] = 1;
                else if ($r <= $c9)
                    $rw[$i + 1] = $this->fsquare(1 - $this->fsquare($r / $cmad));
                else
                    $rw[$i + 1] = 0;
            }
            $iter++;
        }
        return $ys;
    }

    function Rapprox($v, $x, $y, $kind, $f) {
        /* Approximate  y(v),  given (x,y)[i], i = 0,..,n-1 */
        $n = count($x);
        $i = 0;
        $j = $n - 1;
        $f2 = $f;
        $f1 = 1 - $f;
        /* find the correct interval by bisection */

        while ($i < $j - 1) {
            $ij = ($i + $j) / 2;
            if ($v < $x[$ij])
                $j = $ij;
            else
                $i = $ij;
        }
        /* interpolation */
        //outof range
        if ($v == $x[$j])
            return $y[$j];
        if ($v == $x[$i])
            return $y[$i];

        if ($kind == 1) { /* linear */
            if ($x[$j] != $x[$i])
                return $y[$i] + ($y[$j] - $y[$i]) * (($v - $x[$i]) / ($x[$j] - $x[$i]));
            else
                return $y[$i];
        } else { /* 2 : constant */
            return $y[$i] * $f1 + $y[$j] * $f2;
        }
    }

}

?>
