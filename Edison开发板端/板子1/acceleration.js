var mqtt    = require('mqtt');
var mysql   = require('mysql');


//connnect the mysql
var mysqlClient = mysql.createConnection({
    host     : '115.29.109.27',
    user     : 'root',
    password : 'MonkeyGuard309',
    port: '3306',
    database: 'home'
});


var HOST = "115.29.109.27";
var PORT = 61613;
var CLIENT_ID = 'acceleration_edsion';

var options = { host:HOST, port: PORT,username:'admin',password:'password',clientId:CLIENT_ID};

var client  = mqtt.connect(options);

client.on('connect', function () {
    client.subscribe('door');
    client.publish('door', 'door server ok');
});

client.on('message', function (topic, message) {
    console.log(message.toString());
    //client.end();
});

var mraa = require('mraa'); //require mraa

var analogPin0 = new mraa.Aio(0);
var temp_x = analogPin0.read();

var analogPin1 = new mraa.Aio(1);
var temp_y = analogPin1.read();

var analogPin2 = new mraa.Aio(2);
var temp_z = analogPin2.read();

var analogPin3 = new mraa.Aio(3);
var person_x = analogPin3.read();

var analogPin4 = new mraa.Aio(4);
var person_y = analogPin4.read();

var analogPin5 = new mraa.Aio(5);
var person_z = analogPin5.read();

var arduino_power_supply = 12;
var sensor_power_supply = 5;
var zero_g_bias = sensor_power_supply / 2;

var pre_personz;
var pre_x;
var pre_y;
var pre_z;
var person_flag;
var door_flag;

var voltage_x = (temp_x * arduino_power_supply) / 1024;
var x = (voltage_x - zero_g_bias) * 1000 / 330;

var voltage_y = (temp_y * arduino_power_supply) / 1024;
var y = (voltage_y - zero_g_bias) * 1000 / 330;

var voltage_z = (temp_z * arduino_power_supply) / 1024;
var z = (voltage_z - zero_g_bias) * 1000 / 330;

var voltage_person_x = (person_x * arduino_power_supply) / 1024;
var personx = (voltage_person_x - zero_g_bias) * 1000 / 330;

var voltage_person_y = (person_y * arduino_power_supply) / 1024;
var persony = (voltage_person_y - zero_g_bias) * 1000 / 330;

var voltage_person_z = (person_z * arduino_power_supply) / 1024;
var personz = (voltage_person_z - zero_g_bias) * 1000 / 330;

console.log(x.toFixed(2) + "  " + y.toFixed(2) + "  " + z.toFixed(2));
console.log(personx.toFixed(2) + "  " + persony.toFixed(2) + "  " + personz.toFixed(2));

//if(Math.abs(personz.toFixed(2) - pre_personz) >= 3){
//	person_flag = true;
//}
pre_personz = personz.toFixed(2);
//
//if(Math.abs(x.toFixed(2) - pre_x) >= 1 || Math.abs(y.toFixed(2) - pre_y) >= 1 || Math.abs(z.toFixed(2) - pre_z) >= 1){
//	door_flag = true;
//}

pre_x = x.toFixed(2);
pre_y = y.toFixed(2);
pre_z = z.toFixed(2);

//if(person_flag == true && door_flag == true){
//	client.publish("door", '{"is_opened": 1, "is_drop": 1}');
//}
//else if(person_flag == true){
//	client.publish("door", '{"is_opened": 0, "is_drop": 1}');
//}
//else if(door_flag == true){
//	client.publish("door", '{"is_opened": 1, "is_drop": 0}');
//}

person_flag = false;
door_flag = false;

setInterval(function(){
    temp_x = analogPin0.read();
    temp_y = analogPin1.read();
    temp_z = analogPin2.read();

    person_x = analogPin3.read();
    person_y = analogPin4.read();
    person_z = analogPin5.read();

    voltage_x = (temp_x * arduino_power_supply) / 1024;
    x = (voltage_x - zero_g_bias) * 1000 / 330;

    voltage_y = (temp_y * arduino_power_supply) / 1024;
    y = (voltage_y - zero_g_bias) * 1000 / 330;

    voltage_z = (temp_z * arduino_power_supply) / 1024;
    z = (voltage_z - zero_g_bias) * 1000 / 330;

    voltage_person_x = (person_x * arduino_power_supply) / 1024;
    personx = (voltage_person_x - zero_g_bias) * 1000 / 330;

    voltage_person_y = (person_y * arduino_power_supply) / 1024;
    persony = (voltage_person_y - zero_g_bias) * 1000 / 330;

    voltage_person_z = (person_z * arduino_power_supply) / 1024;
    personz = (voltage_person_z - zero_g_bias) * 1000 / 330;

    console.log(x.toFixed(2) + "  " + y.toFixed(2) + "  " + z.toFixed(2));
    console.log(personx.toFixed(2) + "  " + persony.toFixed(2) + "  " + personz.toFixed(2));
    //client.publish("sensor", '{"x":'+x.toFixed(2)+',"y":'+y.toFixed(2)+',"z":'+z.toFixed(2)+'}');

    console.log( Math.abs(personz.toFixed(2) - pre_personz) );
    if(Math.abs(personz.toFixed(2) - pre_personz) >= 1){
        person_flag = true;
    }
    pre_personz = personz.toFixed(2);

    if(Math.abs(x.toFixed(2) - pre_x) >= 1 || Math.abs(y.toFixed(2) - pre_y) >= 1 || Math.abs(z.toFixed(2) - pre_z) >= 1){
        door_flag = true;
    }

    pre_x = x.toFixed(2);
    pre_y = y.toFixed(2);
    pre_z = z.toFixed(2);

    var now = new Date();
    var myTime = now.toLocaleDateString();
    var insert_SQL = "insert into doorOrDrop( index_x, index_y, index_z, time, type) VALUES( ?, ?, ?, ?, ?)";
    var paramDoor = [x, y, z, myTime, "door"];
    var paramDrop = [personx, persony, personz, myTime, "drop"];

    if(person_flag == true && door_flag == true){
        client.publish("door", '{"is_opened": 1, "is_drop": 1}');
        mysqlClient.query(insert_SQL, paramDoor, function (err, result) {
            if(err){
                console.log("[insert error]" + err.message);
                return;
            }
        });
        mysqlClient.query(insert_SQL, paramDrop, function (err, result) {
            if(err){
                console.log("[insert error]" + err.message);
                return;
            }
        });

    }
    else if(person_flag == true){

        client.publish("door", '{"is_opened": 0, "is_drop": 1}');
        mysqlClient.query(insert_SQL, paramDrop, function (err, result) {
            if(err){
                console.log("[insert error]" + err.message);
                return;
            }
        });
    }
    else if(door_flag == true){

        client.publish("door", '{"is_opened": 1, "is_drop": 0}');
        mysqlClient.query(insert_SQL, paramDoor, function (err, result) {
            if(err){
                console.log("[insert error]" + err.message);
                return;
            }
        });
    }

    person_flag = false;
    door_flag = false;

},1000);