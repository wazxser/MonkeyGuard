var value = shared.pin.read();
console.log("measure fire:",value, CONFIG.pin);
sendOUT({value : value});