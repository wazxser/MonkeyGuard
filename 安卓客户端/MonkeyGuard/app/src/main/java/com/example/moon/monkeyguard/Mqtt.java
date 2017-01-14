package com.example.moon.monkeyguard;

import android.os.Handler;
import org.eclipse.paho.client.mqttv3.*;
import org.eclipse.paho.client.mqttv3.persist.MemoryPersistence;

public class Mqtt {
    public String ret = "No data";
    private Handler handler;
    private Handler handler2;
    private String broker;
    private String userName;
    private String password;
    private String topic;
    private String msg;
    private Integer qos;
    private String clientId;
    private String content;
    private boolean isConnected = false;

    private MemoryPersistence persistence;//
    private MqttClient mqttClient;
    private MqttConnectOptions mqttConnectOptions;
    private MqttMessage message;

    public void setHandler(Handler handler){this.handler = handler;}

    public void setHandler2(Handler handler){this.handler2 = handler;}

    public String getContent() {
        return content;
    }

    public void setContent(String content) {
        this.content = content;
    }

    public String getBroker() {
        return broker;
    }

    public void setBroker(String broker) {
        this.broker = broker;
    }

    public String getUserName() {
        return userName;
    }

    public void setUserName(String userName) {
        this.userName = userName;
    }

    public String getTopic() {
        return topic;
    }

    public void setTopic(String topic) {
        this.topic = topic;
    }

    public String getMsg() {
        return msg;
    }

    public void setMsg(String msg) {
        this.msg = msg;
    }

    public Integer getQos() {
        return qos;
    }

    public void setQos(Integer qos) {
        this.qos = qos;
    }

    public String getPassword() {
        return password;
    }

    public void setPassword(String password) {
        this.password = password;
    }

    public boolean isConnected() {
        return isConnected;
    }

    public void setConnected(boolean connected) {
        isConnected = connected;
    }

    public String getClientId() {
        return clientId;
    }

    public void setClientId(String clientId) {
        this.clientId = clientId;
    }

    void init() {
        persistence = new MemoryPersistence();
        mqttConnectOptions = new MqttConnectOptions();
        mqttConnectOptions.setCleanSession(false);
        mqttConnectOptions.setKeepAliveInterval(18330);
        mqttConnectOptions.setUserName(userName);
        mqttConnectOptions.setPassword(password.toCharArray());
        message = new MqttMessage(content.getBytes());
        try {
            mqttClient = new MqttClient(broker, clientId, persistence);
            mqttClient.setCallback(new MqttCallback() {
                @Override
                public void connectionLost(Throwable throwable) {
                    isConnected = false;
                    System.out.println("lost connecion");
                }

                @Override
                public void messageArrived(String s, MqttMessage mqttMessage) throws Exception {
                    System.out.println("message arrived:"+mqttMessage.toString());
                    ret = mqttMessage.toString();
                    int length = ret.length();
                    if(length > 35) {
                        handler.sendEmptyMessage(1);
                        System.out.println("sensor message");
                    }
                    else{
                        handler2.sendEmptyMessage(98);
                        System.out.println("door message");
                    }
                }

                @Override
                public void deliveryComplete(IMqttDeliveryToken iMqttDeliveryToken) {
                    System.out.println(iMqttDeliveryToken.toString());
                }
            });
            if(!isConnected){
                mqttClient.connect(mqttConnectOptions);
                System.out.println("connect to broker"+broker);
            }
            isConnected = true;
        } catch (MqttException me) {
            System.out.println("reason " + me.getReasonCode());
            System.out.println("msg " + me.getMessage());
            System.out.println("loc " + me.getLocalizedMessage());
            System.out.println("cause " + me.getCause());
            System.out.println("excep " + me);
            me.printStackTrace();
        }
    }

    void listen(){
        try {
            mqttClient.subscribe(topic);
        } catch (MqttException me) {
            System.out.println("reason " + me.getReasonCode());
            System.out.println("msg " + me.getMessage());
            System.out.println("loc " + me.getLocalizedMessage());
            System.out.println("cause " + me.getCause());
            System.out.println("excep " + me);
            me.printStackTrace();
        }
    }
    void send(){
        message.setQos(qos);
        try {
            mqttClient.publish(topic, message);
        } catch (MqttException me) {
            System.out.println("reason " + me.getReasonCode());
            System.out.println("msg " + me.getMessage());
            System.out.println("loc " + me.getLocalizedMessage());
            System.out.println("cause " + me.getCause());
            System.out.println("excep " + me);
            me.printStackTrace();
        }
    }
}
