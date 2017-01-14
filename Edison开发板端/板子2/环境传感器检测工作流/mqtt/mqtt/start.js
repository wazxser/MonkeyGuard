shared.mqtt = require('mqtt');

var options = { host:CONFIG.host, port: CONFIG.port,username:'admin',password:'password',clientId:CONFIG.client_id};

shared.client  = shared.mqtt.connect(options);

done();