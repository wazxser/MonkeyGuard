// var spawn = require("child_process").spawn;
// var child1 = spawn("node", ['mqtt.js'], ['~/']);

// var shell = require("shelljs");

// var value = IN.in1;

// shell.exec("node mqtt.js " + "'" + value + "'");

// sendOUT({out1: value});

// shared.client.on('connect', function () {
//     client.subscribe('sensor');
    
//     client.publish('sensor', 'sensor server ok');

// });

// shared.client.on('message', function (topic, message) {
//     console.log(message.toString());
// 	//client.end();
// });

var value = '{"temp_value":'+IN.temp+',"fire_value":'+IN.fire+',"fog_value":'+IN.fog+'}';

sendOUT({value : value});
shared.client.publish("sensor", '{"temp_value":'+IN.temp+',"fire_value":'+IN.fire+',"fog_value":'+IN.fog+'}');
