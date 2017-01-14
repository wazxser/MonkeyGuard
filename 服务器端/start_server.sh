acceptImagePid=$(ps -ef | grep "java -cp .:faceppsdk.jar AcceptImage" | grep -v grep | awk '{print $2}')
kill $acceptImagePid 2>/dev/null
echo "kill AcceptImage"

androidServerPid=$(ps -ef | grep "java AndroidServer" | grep -v grep | awk '{print $2}')
kill $androidServerPid 2>/dev/null
echo "kill AndroidServer"

apolloPid=$(ps -ef | grep "apollo" | grep -v grep | awk '{print $2}')
kill -9 $apolloPid 2>/dev/null
echo "kill apollo"

echo "start apollo-broker..."
/opt/mybroker/bin/apollo-broker run > apollo.log &

echo "start AcceptImage..."
java -cp .:faceppsdk.jar AcceptImage > AcceptImage.log &

echo "start AndroidServer..."
java AndroidServer > AndroidServer.log &
