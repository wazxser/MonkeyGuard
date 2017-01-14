<?php
namespace Home\Controller;
use Think\Controller;
header('Content-Type:text/html; charset=utf-8');
class IndexController extends Controller {
    public function index(){
        $m = M('home');

        //异常的天数
        $begin = date("Y-m").'-01 00:00:00';

        $Model = new \Think\Model();
        $queryT = "select date_format(time, '%y%m%d')days,
                count(*)COUNT, time, num, id, sensor
                from home 
                where time > '$begin' and sensor = 'temp' and (num > '30' or num < '10')
                group by days order by time ASC";
        $resultT = $Model->query($queryT);

        $queryFi = "select date_format(time, '%y%m%d')days,
                count(*)COUNT, time, sensor, num, id
                from home 
                where time > '$begin' and sensor = 'fire' and num > '300'
                group by days 
                order by time ASC";
        $resultFi = $Model->query($queryFi);
        $queryFo = "select date_format(time, '%y%m%d')days,
                count(*)COUNT, time, sensor, id, num
                from home 
                where time > '$begin' and sensor = 'fog' and num > '300'
                group by days
                order by time ASC";
        $resultFo = $Model->query($queryFo);
        $queryD = "select date_format(time, '%y%m%d')days,
                count(*)COUNT, time, type, id
                from door 
                where time > '$begin' and type = 'door'
                group by days
                order by time ASC";
        $resultD = $Model->query($queryD);
        $queryDp = "select date_format(time, '%y%m%d')days,
                count(*)COUNT, time, type, id
                from door
                where time > '$begin' and type = 'drop'
                group by days
                order by time ASC";
        $resultDp = $Model->query($queryDp);
        $temp = sizeof($resultT);
        $fire = sizeof($resultFi);
        $gas = sizeof($resultFo);
        $door = sizeof($resultD);
        $old = sizeof($resultDp);

        $this->assign('temp',$temp);
        $this->assign('lalal',$door);
        $this->assign('fire',$fire);
        $this->assign('gas',$gas);
        $this->assign('old1',$old);

        $t=0;
        $fi=0;
        $fo=0;
        $da = date("Y-m-");
        //搜索每天的异常次数
        $data = "";
            for($i = 1; $i <= date("d"); $i++){
                $data .= "{time: '".$da.$i."'".",";
                if(date('d',strtotime($resultT[$t]['time']))!=$i){
                    $data .= 'temp: 0'.",";
                }else{
                    $data .= 'temp: '.$resultT[$t]['count'].",";
                   // dump($resultT[$i]['count']);
                    $t++;
                }
                if(date('d',strtotime($resultFi[$fi]['time']))!=$i){
                     $data .= 'fire: 0'.",";
                }else{
                    $data .='fire: '. $resultFi[$fi]['count'].",";
                    $fi++;
                }
                if(date('d',strtotime($resultFo[$fo]['time']))!=$i){
                    $data .= 'fog: 0'."},";
                }else{
                    $data .= 'fog: '.$resultFo[$fo]['count']."},";
                    $fo++;
                }

            }
        $data = substr($data, 0, -1);
        $this->assign('data',$data);


        $chose=$_GET['chose'];
        if($chose==null || $chose==1){
            $query = "select time, num, id, sensor
                from home 
                where time > '$begin' and sensor = 'temp' and (num > '30' or num < '10')
                order by time ASC";
            $this->assign('sensor', 温度);
        }else if($chose==2){
            $query = "select time, sensor, num, id
                from home 
                where time > '$begin' and sensor = 'fire' and num > '300'
                order by time ASC";
            $this->assign('sensor', 火焰);
        }else if($chose==3){
            $query = "select time, sensor, id, num
                from home 
                where time > '$begin' and sensor = 'fog' and (num > '300')
                order by time ASC";
            $this->assign('sensor', "可燃气体");
        }
        $result = $Model->query($query);
        $this->assign('abT', $result);

        for($k=0; $k<sizeof($result); $k++){
            $data1 .= "{time: '".$result[$k]['time']."'".",";
            $data1 .= 'sensor: '.$result[$k]['num']."},";
        }
       
        $data1 = substr($data1, 0, -1);
        $this->assign('data1',$data1);

        //开门检测
        $query = "select date_format(time, '%y%m%d%h')hours,
                count(*)COUNT, time, type, id
                from door 
                where time > '$begin' and type = 'door'
                group by hours
                order by time ASC";
        $result = $Model->query($query);
        $this->assign('door', $result);

        $queryo = "select date_format(time, '%y%m%d%h')hours,
                count(*)COUNT, time, type, id
                from door 
                where time > '$begin' and type = 'drop'
                group by hours
                order by time ASC";
        $resulto = $Model->query($queryo);
        $this->assign('drop', $resulto);

        if($chose == 2) {
            $sensor = "火焰";
        }
        elseif($chose == 3){
            $sensor = "可燃气体";
        }
        else{
            $sensor = "温度";
        }

        $this->assign('sensor', $sensor);
        $this->display();
    }
    public function temp(){
        $day = I('get.day');
        if(empty($day)){
            $day = date("Y-m-d");
        }

        //查询每小时温度变化
        $dname = $day." 日每小时温度变化";
        $this->assign('dname',$dname);

        $begin = $day." 00:00:00";
        $end = $day." 23:59:59";
        $Model = new \Think\Model();
        $queryD = "select date_format(time, '%y%m%d%h')hours,
                time, AVG(num)avg, id, sensor
                from home 
                where sensor = 'temp'
                group by hours
                having time > '$begin' and time < '$end'
                order by time ASC";
        $resultD = $Model->query($queryD);
        $length = sizeof($resultD);

        $dataT = "";
        $dataD = "";
        for($i = 0; $i < $length; $i++){
            $dataD .= sprintf("%.1f",$resultD[$i]['avg']).",";
            $time = $resultD[$i]['time'];
            $dataT .= "'".date("H",strtotime($time))."'".",";
        }
        $dataT = substr($dataT, 0, -1);
        $this->assign('data0',$dataT);
        $dataD = substr($dataD, 0, -1);
        $this->assign('dataD',$dataD);
        $this->assign('n', $length);

        //查询每月的每天最高最低值
        $month = I('get.month');
        if(empty($month)){
            $month = date('Y-m');
        }else{
            $month = date('Y-').$month;
        }
        $mname = $month." 月";
        $this->assign('mname',$mname);

        $begin = $month.'-01 00:00:00';
        //$begin = "2016-09-01 00:00:00";
        $end = $month.'-31 23:59:59';

        $queryT = "select date_format(time, '%y%m%d')days,
                count(*)COUNT, time, num, id, sensor
                from home 
                where time > '$begin' and time < '$end' and sensor = 'temp' and (num > '30' or num < '10')
                group by days";
        $resultT = $Model->query($queryT);
        $total = sizeof($resultT);
        $fenmu = date('t', strtotime($month));
        $rate = $total*100 / $fenmu;
        $this->assign('rate', sprintf("%.1f",$rate) );

        $queryM = "select date_format(time, '%y%m%d')days,
                MAX(num)max, MIN(num)min, time, num, id, sensor
                from home 
                where time > '$begin' and time < '$end' and sensor = 'temp'
                group by days";
        $resultM = $Model->query($queryM);

        $year = date("Y");
        $beginY = $year."-01-01 00:00:00";
        $endY = $year."-12-31 59:59:59";
        $queryY = "select date_format(time, '%y%m')months,
                AVG(num)avg, time, num, id, sensor
                from home 
                where time > '$beginY' and time < '$endY' and sensor = 'temp'
                group by months";
        $resultY = $Model->query($queryY);

        $dataY = "";
        for($i=0; $i<sizeof($resultY); $i++){
            $time = $resultY[$i]['time'];
            $y=date("Y-m",strtotime($time));
            $head = (strtotime($y."-08 00:00:00")-strtotime("1970-01-01 00:00:00"))*1000;
            $dataY .= "[".$head.",".sprintf("%.1f",$resultY[$i]['avg'])."]".",";
        }
        $dataY = substr($dataY, 0, -1);
        $this->assign('dataY', $dataY);

        $dataM = "";
        $dataMax = "";
        $dataMin = "";
        for($i = 0; $i < sizeof($resultM); $i++){
            $time = $resultM[$i]['time'];
            //dump($time);
            $dataM .= "'".date('Y-m-d', strtotime($time))."'".",";
            $dataMax .= sprintf("%.1f",$resultM[$i]['max']).",";
            $dataMin .= sprintf("%.1f",$resultM[$i]['min']).",";
        }
        $dataM = substr($dataM, 0, -1);
        $dataMax = substr($dataMax, 0, -1);
        $dataMin = substr($dataMin, 0, -1);
        $this->assign('dataM',$dataM);
        $this->assign('dataMax',$dataMax);
        $this->assign('dataMin',$dataMin);

        $this->display();
    }
    public function fire(){
        $day = $_GET["day"];
        if($day == NULL){
            $day = date("Y-m-d");
        }
        //查询每小时温度变化
        $dname = $day." 日每小时火焰传感器数值变化";
        $this->assign('dname',$dname);

        $begin = $day." 00:00:00";
        $end = $day." 23:59:59";
        $Model = new \Think\Model();
        $queryD = "select date_format(time, '%y%m%d%h')hours,
                time, AVG(num)avg, id, sensor
                from home 
                where sensor = 'fire'
                group by hours
                having time > '$begin' and time < '$end'
                order by time ASC";
        $resultD = $Model->query($queryD);
        $length = sizeof($resultD);

        $dataD = "";
        $dataN = "";
        $data0 = "";
        for($i = 0; $i < $length; $i++){
            $dataD .= $resultD[$i]['avg'].",";
            $dataN .= '200'.",";
            $time = $resultD[$i]['time'];
            $data0 .= "'".date("H",strtotime($time))."'".",";
        }

        $data0 = substr($data0, 0, -1);
        $this->assign('data0',$data0);
        $dataN = substr($dataN, 0, -1);
        $this->assign('dataN',$dataN);
        $dataD = substr($dataD, 0, -1);
        $this->assign('dataD',$dataD);
        $this->assign('n', $length);

        //查询每月的每天最高最低值
        $month = $_GET['month'];
        if($month == ''){
            $month = date('Y-m');
        }else{
            $month = date('Y-').$month;
        }
        $mname = $month." 月";
        $this->assign('mname',$mname);

        $begin = $month.'-01 00:00:00';
        //$begin = "2016-09-01 00:00:00";
        $end = $month.'-31 23:59:59';

        $queryT = "select date_format(time, '%y%m%d')days,
                count(*)COUNT, time, num, id, sensor
                from home 
                where time > '$begin' and time < '$end' and sensor = 'fire' and (num > '200')
                group by days";
        $resultT = $Model->query($queryT);
        $total = sizeof($resultT);
        $fenmu = date('t', strtotime($month));
        $rate = $total*100 / $fenmu;
        $this->assign('rate', sprintf("%.1f",$rate) );

        $queryM = "select date_format(time, '%y%m%d')days,
                MAX(num)max, MIN(num)min, time, num, id, sensor
                from home 
                where time > '$begin' and time < '$end' and sensor = 'fire'
                group by days";
        $resultM = $Model->query($queryM);

        $year = date("Y");
        $beginY = $year."-01-01 00:00:00";
        $endY = $year."-12-31 59:59:59";
        $queryY = "select date_format(time, '%y%m')months,
                AVG(num)avg, time, num, id, sensor
                from home 
                where time > '$beginY' and time < '$endY' and sensor = 'fire'
                group by months";
        $resultY = $Model->query($queryY);

        $dataY = "";
        for($i=0; $i<sizeof($resultY); $i++){
            $time = $resultY[$i]['time'];
            $y=date("Y-m",strtotime($time));
            $head = (strtotime($y."-08 00:00:00")-strtotime("1970-01-01 00:00:00"))*1000;
            $dataY .= "[".$head.",".sprintf("%.1f",$resultY[$i]['avg'])."]".",";
        }
        $dataY = substr($dataY, 0, -1);
        $this->assign('dataY', $dataY);

        $dataM = "";
        $dataMax = "";
        $dataMin = "";
        for($i = 0; $i < sizeof($resultM); $i++){
            $time = $resultM[$i]['time'];
            //dump($time);
            $dataM .= "'".date('Y-m-d', strtotime($time))."'".",";
            $dataMax .= $resultM[$i]['max'].",";
            $dataMin .= $resultM[$i]['min'].",";
        }
        $dataM = substr($dataM, 0, -1);
        $dataMax = substr($dataMax, 0, -1);
        $dataMin = substr($dataMin, 0, -1);
        $this->assign('dataM',$dataM);
        $this->assign('dataMax',$dataMax);
        $this->assign('dataMin',$dataMin);

        $this->display();
    }
    public function gas(){
        $day = $_GET["day"];
        if($day == NULL){
            $day = date("Y-m-d");
        }
        //查询每小时温度变化
        $dname = $day." 日每小时可燃气体平均值变化";
        $this->assign('dname',$dname);

        $begin = $day." 00:00:00";
        $end = $day." 23:59:59";
        $Model = new \Think\Model();
        $queryD = "select date_format(time, '%y%m%d%h')hours,
                time, AVG(num)avg, id, sensor
                from home 
                where sensor = 'fog'
                group by hours
                having time > '$begin' and time < '$end'
                order by time ASC";
        $resultD = $Model->query($queryD);
        $length = sizeof($resultD);

        $dataD = "";
        $data0 = "";
        for($i = 0; $i < $length; $i++){
            $dataD .= sprintf("%.1f",$resultD[$i]['avg']).",";
            $time = $resultD[$i]['time'];
            $data0 .= "'".date("H",strtotime($time))."'".",";
        }
        $data0 = substr($data0, 0, -1);
        $this->assign('data0',$data0);
        $dataD = substr($dataD, 0, -1);
        $this->assign('dataD',$dataD);
        $this->assign('n', $length);

        //查询每月的每天最高最低值
        $month = $_GET['month'];
        if($month == ''){
            $month = date('Y-m');
        }else{
            $month = date('Y-').$month;
        }
        $mname = $month." 月";
        $this->assign('mname',$mname);

        $begin = $month.'-01 00:00:00';
        //$begin = "2016-09-01 00:00:00";
        $end = $month.'-31 23:59:59';

        $queryT = "select date_format(time, '%y%m%d')days,
                count(*)COUNT, time, num, id, sensor
                from home 
                where time > '$begin' and time < '$end' and sensor = 'fog' and (num > '300')
                group by days";
        $resultT = $Model->query($queryT);
        $total = sizeof($resultT);
        $fenmu = date('t', strtotime($month));
        $rate = $total*100 / $fenmu;
        $this->assign('rate', sprintf("%.1f",$rate) );

        $queryM = "select date_format(time, '%y%m%d')days,
                MAX(num)max, MIN(num)min, time, num, id, sensor
                from home 
                where time > '$begin' and time < '$end' and sensor = 'fog'
                group by days";
        $resultM = $Model->query($queryM);

        $year = date("Y");
        $beginY = $year."-01-01 00:00:00";
        $endY = $year."-12-31 59:59:59";
        $queryY = "select date_format(time, '%y%m')months,
                AVG(num)avg, time, num, id, sensor
                from home 
                where time > '$beginY' and time < '$endY' and sensor = 'fog'
                group by months";
        $resultY = $Model->query($queryY);
        $dataY = "";
        for($i=0; $i<sizeof($resultY); $i++){
            $time = $resultY[$i]['time'];
            $y=date("Y-m",strtotime($time));
            $head = (strtotime($y."-08 00:00:00")-strtotime("1970-01-01 00:00:00"))*1000;
            $dataY .= "[".$head.",".sprintf("%.1f",$resultY[$i]['avg'])."]".",";
        }
        $dataY = substr($dataY, 0, -1);
        $this->assign('dataY', $dataY);

        $dataM = "";
        $dataMax = "";
        $dataMin = "";
        for($i = 0; $i < sizeof($resultM); $i++){
            $time = $resultM[$i]['time'];
            //dump($time);
            $dataM .= "'".date('Y-m-d', strtotime($time))."'".",";
            $dataMax .= $resultM[$i]['max'].",";
            $dataMin .= $resultM[$i]['min'].",";
        }
        $dataM = substr($dataM, 0, -1);
        $dataMax = substr($dataMax, 0, -1);
        $dataMin = substr($dataMin, 0, -1);
        $this->assign('dataM',$dataM);
        $this->assign('dataMax',$dataMax);
        $this->assign('dataMin',$dataMin);

        $this->display();
    }
    public function lists(){
        // require_once 'facepp_sdk.php';
        import("facepp_sdk",dirname(__FILE__),".php");

        $facepp = new \Facepp();
        $facepp->api_key       = 'c99a07af30ed83c07757b9bec46e8b8b';
        $facepp->api_secret    = 'K8F1T3lzc8WLW5NEJS-wWCz6mJ7PN5Rw';

        $key = 'c99a07af30ed83c07757b9bec46e8b8b';
        $secret = 'K8F1T3lzc8WLW5NEJS-wWCz6mJ7PN5Rw';


//获取所有人的列表
        $params['url'] = 'https://apicn.faceplusplus.com/v2/info/get_person_list?api_secret=$secret&api_key=$key';
        $response = $facepp->execute('/info/get_person_list', $params);
        $person_body = json_decode($response['body'], 1);
        //dump($person_body);
        $person = $person_body['person'];
        //dump($person);
        $total = sizeof($person);
        $i = 0;
        foreach ($person as $people) {

            if($people['tag']!=''){
                $lists[$i]['num'] = $i+1;
                $lists[$i]['id'] = $people['person_name'];
                $lists[$i]['name'] = $people['tag'];

                //分别获取每个人的face_id
                $params['person_id'] = $people['person_id'];
                $params['url'] = 'https://apicn.faceplusplus.com/v2/person/get_info?api_key=$key&api_secret=$secret';
                $response = $facepp->execute('/person/get_info', $params);
                // dump($response);

                $face_body = json_decode($response['body'], 1);
                //dump($face_body);
                $face = $face_body['face'];
                //dump($face);
                $times=sizeof($face);
                $face_id = $face['0']['face_id'];
                //dump($face_id);



                //获得img_id
                $params['face_id'] = $face_id;
                $params['url'] = 'https://apicn.faceplusplus.com/v2/info/get_face?api_key=$key&api_secret=$secret';
                $response = $facepp->execute('/info/get_face', $params);
                // dump($response);

                $get_face = json_decode($response['body'], 1);
                // dump($get_face);
                $face_info = $get_face['face_info'];
                //dump($face_info);
                $img = $face_info['0']['url'];
                $lists[$i]['img'] = $img;
                $lists[$i]['times'] = $times;

                $i++;
            }
        }

        $this->assign('lists',$lists);
        $this->display();
    }
    public function contact(){
        if(I('post.')){
            $name = I('post.name');
            $phone = I('post.phone');
            $email = I('post.email');
            $c = M('contact');
            $where['name'] = $name;
            $where['phone'] = $phone;
            $where['email'] = $email;
            $where['time'] = date("Y-m-d H:i:s");
            $where['message'] = I("post.message");
            $result = $c->add($where);
            if($result){
                echo"<script>alert('提交成功')</script>";
            }else{
                echo"<script>alert('提交失败，请重新输入')</script>";
            }
        }
        $this->display();
    }
    public function logout(){
        session_destroy();
        echo '<script>alert("注销成功");</script>';
        echo '<script>window.location.href="http://115.29.109.27/MonkeyGuard/index.php/Home/Login/login";</script>';
    }

    public function data(){
        $m = M('home');
        function rand_number($min, $max){
            return sprintf("%0".strlen($max)."d", mt_rand($min,$max));
        }

        for($i=4;$i<11;$i++){
            $hour1 = rand_number(1,24);
            $minute1 = rand_number(1,60);
            $second1 = rand_number(1,60);

            $record1_t['time'] = "2016-11-".$i." ".$hour1.":".$minute1.":".$second1;
            $record1_t['sensor'] = "temp";
            //$record1_t['num'] = rand_number(0,10);
            $record1_t['num'] = rand_number(10,20);
            //$record1_t['num'] = rand_number(20,30);
            $result = $m -> add($record1_t);
            if(!$result){
                dump("wendu");
                exit();
            }

            $record1_fi['time'] = "2016-11-".$i." ".$hour1.":".$minute1.":".$second1;
            $record1_fi['sensor'] = "fire";
            $record1_fi['num'] = rand_number(210,230);
           // $record1_fi['num'] = rand_number(500,900);
            $result = $m -> add($record1_fi);
            if(!$result){
                dump("fire");
                exit();
            }

            $record1_fo['time'] = "2016-11-".$i." ".$hour1.":".$minute1.":".$second1;
            $record1_fo['sensor'] = "fog";
            $record1_fo['num'] = rand_number(200,230);
            //$record1_fo['num'] = rand_number(300,500);
            $result = $m -> add($record1_fo);
            if(!$result){
                dump("fog");
                exit();
            }


//            dump($record1_t);
//            dump($record1_fi);
//            dump($record1_fo);
        }

    }//用于数据更新的函数

    public function tables(){
        $conn = M('door');

        $month = I('get.month');

        if($month){
            $num = $month;
        }
        else{
            $num = date("m");
        }

        $select = $conn->where(array('type' => 'drop'))->select();
        for($i = 0; $i < sizeof($select); $i++){
            $year = date('Y');
            if(substr($select[$i]['time'], 0, 4) == $year){
                if(substr($select[$i]['time'], 5, 2) == $num){
                    $array[$i]['id'] = $select[$i]['id'];
                    $array[$i]['date'] = substr($select[$i]['time'], 0, 10);
                    $array[$i]['time'] = substr($select[$i]['time'], 10);
                }
            }
        }

        $this->assign('array', $array);
        $this->assign('month', $num);
        $this->show();
    }

    public function lasttables(){
        $conn = M('door');

        $month = I('get.month');

        if($month){
            $num = $month;
        }
        else{
            $num = 1;
        }

        $select = $conn->where(array('type' => 'drop'))->select();
        for($i = 0; $i < sizeof($select); $i++){
            if(substr($select[$i]['time'], 5, 2) == $num){
                $array[$i]['id'] = $select[$i]['id'];
                $array[$i]['date'] = substr($select[$i]['time'], 0, 10);
                $array[$i]['time'] = substr($select[$i]['time'], 10);
            }
        }

        $this->assign('array', $array);
        $this->assign('month', $num);
        $this->show();
    }

    public function doortables(){
        $conn = M('door');

        $month = I('get.month');

        if($month){
            $num = $month;
        }
        else{
            $num = date("m");
        }

        $select = $conn->where(array('type' => 'door'))->select();
        for($i = 0; $i < sizeof($select); $i++){
            $year = date('Y');
            if(substr($select[$i]['time'], 0, 4) == $year){
                if(substr($select[$i]['time'], 5, 2) == $num){
                    $array[$i]['id'] = $select[$i]['id'];
                    $array[$i]['date'] = substr($select[$i]['time'], 0, 10);
                    $array[$i]['time'] = substr($select[$i]['time'], 10);
                }
            }
        }

        $this->assign('array', $array);
        $this->assign('month', $num);
        $this->show();
    }

    public function lastdoor(){
        $conn = M('door');

        $month = I('get.month');

        if($month){
            $num = $month;
        }
        else{
            $num = date("m");
        }

        $select = $conn->where(array('type' => 'door'))->select();
        for($i = 0; $i < sizeof($select); $i++){
            if(substr($select[$i]['time'], 5, 2) == $num){
                $array[$i]['id'] = $select[$i]['id'];
                $array[$i]['date'] = substr($select[$i]['time'], 0, 10);
                $array[$i]['time'] = substr($select[$i]['time'], 10);
            }
        }

        $this->assign('array', $array);
        $this->assign('month', $num);
        $this->show();
    }

    public function fog(){
        $this->show();
    }
}