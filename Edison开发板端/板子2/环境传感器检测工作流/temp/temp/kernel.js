var value = shared.pin.read() *5/10.24-14 - 40;
console.log("measure fire:",value, CONFIG.pin);
sendOUT({value : value});