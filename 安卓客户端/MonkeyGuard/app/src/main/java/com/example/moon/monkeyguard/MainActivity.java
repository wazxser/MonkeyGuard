package com.example.moon.monkeyguard;

import android.app.Notification;
import android.content.Intent;
import android.graphics.Bitmap;
import android.media.Image;
import android.os.Handler;
import android.os.Message;
import android.support.v4.view.PagerAdapter;
import android.support.v4.view.ViewPager;
import android.os.Bundle;
import android.support.v7.app.NotificationCompat;
import android.view.KeyEvent;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.Button;
import android.widget.ImageView;
import android.widget.RelativeLayout;
import android.widget.TextView;
import android.widget.Toast;

import org.json.JSONException;
import org.json.JSONObject;

import java.io.File;
import java.io.FileInputStream;
import java.io.IOException;
import java.util.ArrayList;
import java.util.Iterator;
import java.util.List;
import java.util.Random;
import java.util.Timer;
import java.util.TimerTask;

//主类
public class MainActivity extends NotificationBase {
    //接收常连接的消息
    public Handler handler;
    public Handler handler2;

    private Handler imgHandler;
    private String imgUrl = "nulll";
    private Bitmap imgData = null;
    private String imgType;

    private Mqtt mqtt;
    private Mqtt mqtt2;

    private View view1, view2, view3, view4;//需要滑动的页卡
    private ViewPager viewPager;//viewpager
    private List<View> viewList;//把需要滑动的页卡添加到这个list中
    private Intent intent;
    private List<String> titleList;

    //传感器
    String sensorName [] = {"temp_value", "fire_value", "fog_value"};
    int senorValue [] = {30, 100, 150};
    String doorName [] = {"is_opened", "is_drop"};
    int doorValue [] = {0, 0};

    //Notification
    //public NotificationManager mNotificationManager;
    NotificationCompat.Builder mBuilder;
    int notifyId = 100;

    //传感器的值的呈现
    TextView temp_text;
    TextView fog_text;
    TextView fire_text;
    TextView temp_main;
    TextView fog_main;
    TextView fog_main_ok;
    TextView fire_main_ok;

    //折线图实例
    ChartView tempChart = null;
    FogChartView fogChart = null;
    FireChartView fireChart = null;

    LineView lineView = null;

    Button doorB;
    Button personB;

    Boolean doorFlag = false;

    TextView text_temp;
    TextView text_fire;
    TextView text_fog;

    final AcceptImage acceptImage = new AcceptImage();

    private Handler tempHandler = new Handler(){
        public void handleMessage(Message msg) {
            if(msg.what == 0x1234){
                temp_text.setText(String.valueOf(senorValue[0]) + "℃");
            }
        };
    };

    private Handler fogHandler = new Handler(){
        public void handleMessage(Message msg) {
            if(msg.what == 0x2345){
                fog_text.setText(String.valueOf(senorValue[2]));
            }
        };
    };

    private Handler fireHandler = new Handler(){
        public void handleMessage(Message msg) {
            if(msg.what == 0x3456){
                fire_text.setText(String.valueOf(senorValue[1]));
            }
        };
    };

    @Override
    protected void onCreate(Bundle savedInstanceState){
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_sensor);

        acceptImage.getImage();

        imgHandler = new Handler(){
            public void handleMessage(Message msg){
                if(msg.what == 2){
                    imgUrl = acceptImage.getImgUrl();
//                    imgData = acceptImage.getData();
                    initNotify();
                    showImgNotify();
                }
            }
        };
        acceptImage.setHandler(imgHandler);

        LayoutInflater lf = getLayoutInflater().from(this);

        view1 = lf.inflate(R.layout.activity_main, null);
        view2 = lf.inflate(R.layout.activity_temp, null);
        view3 = lf.inflate(R.layout.activity_fog, null);
        view4 = lf.inflate(R.layout.activity_fire, null);

        initViewPager();
        initMainView();

        viewPager.setOnPageChangeListener(new ViewPager.OnPageChangeListener() {
              @Override
              public void onPageSelected(int arg0) {
                  // TODO Auto-generated method stub
                  switch (arg0) {
                      case 0:

                          break;
                      case 1:
                          temp_text = (TextView)findViewById(R.id.temp_text);
                          temp_text.setText(String.valueOf(senorValue[0]) + "℃");
                          tempChart = (ChartView)findViewById(R.id.tempChart);

                          new Thread(new Runnable() {
                              @Override
                              public void run() {
                                  while(true){
                                      try {
                                          Thread.sleep(1000);
                                      } catch (InterruptedException e) {
                                          e.printStackTrace();
                                      }

                                      tempHandler.sendEmptyMessage(0x1234);
                                  }
                              }
                          }).start();

                          break;
                      case 2:
                          fog_text = (TextView)findViewById(R.id.fog_text);
                          fog_text.setText(String.valueOf(senorValue[2]));

                          fogChart = (FogChartView)findViewById(R.id.fogChart);

                          new Thread(new Runnable() {
                              @Override
                              public void run() {
                                  while(true){
                                      try {
                                          Thread.sleep(1000);
                                      } catch (InterruptedException e) {
                                          e.printStackTrace();
                                      }

                                      fogHandler.sendEmptyMessage(0x2345);
                                  }
                              }
                          }).start();

                          break;
                      case 3:
                          fire_text = (TextView)findViewById(R.id.fire_text);
                          fire_text.setText(String.valueOf(senorValue[1]));

                          fireChart = (FireChartView)findViewById(R.id.fireChart);

                          new Thread(new Runnable() {
                              @Override
                              public void run() {
                                  while(true){
                                      try {
                                          Thread.sleep(1000);
                                      } catch (InterruptedException e) {
                                          e.printStackTrace();
                                      }

                                      fireHandler.sendEmptyMessage(0x3456);
                                  }
                              }
                          }).start();

                          break;
                      default:
                          break;
                  }
              }

            @Override
            public void onPageScrolled(int arg0, float arg1, int arg2) {

            }

            @Override
            public void onPageScrollStateChanged(int arg0) {
                // TODO Auto-generated method stub

            }
        });

        mqtt = new Mqtt();
        setMqtt();

        mqtt2 = new Mqtt();
        setMqtt2();

        handler = new Handler() {
            public void handleMessage(Message msg) {
                if (msg.what == 1) {
                    try{
                        if(mqtt.ret != "message arrived:sensor server ok") {
                            decodeJson(mqtt.ret);
                        }
                        if(tempChart != null){
                            tempChart.setMessage(senorValue[0]);
                        }
                        else{
                            System.out.println("tempChart is null");
                        }

                        if(fogChart != null){
                            fogChart.setMessage(senorValue[2]);
                        }
                        else{
                            System.out.println("fogChart is null");
                        }

                        if(fireChart != null){
                            fireChart.setMessage(senorValue[1]);
                        }
                        else{
                            System.out.println("fireChart is null");
                        }

                        if(lineView != null) {
                            lineView.person = (float)150;
                            lineView.door = (float)150;
                            lineView.image = (float)150;
                            lineView.fog = (float)senorValue[2];
                            lineView.fire = (float)senorValue[1];
                            lineView.temp = (float)senorValue[0];
                        }

                        initNotify();
                        if(senorValue[0] > 50){
                            showTempNotify();
                        }
                        else if(senorValue[1] > 200){
                            showFireNotify();
                        }
                        else if(senorValue[2] > 500){
                            showFogNotify();
                        }
                    }
                    catch(JSONException e){
                        System.out.println("Json解析出错");
                        e.printStackTrace();
                    }
                }
                else if(msg.what == 98){
                    System.out.println("door message");
                }
            }
        };
        mqtt.setHandler(handler);

        handler2 = new Handler(){
            public void handleMessage(Message msg){
                if(msg.what == 98){
                    System.out.println("door message2");
                    String str = mqtt2.ret;
                    try{
                        if(str != "message arrived:door server ok") {
                            if (doorFlag == true) {
                                decodeJson2(str);
                                initNotify();
                                if (doorValue[0] == 1) {
                                    showDoorNotify();
                                    if(lineView != null){
                                        lineView.door = 250;
                                    }
                                }
                                if (doorValue[1] == 1) {
                                    showPersonNotify();
                                    if(lineView != null){
                                        lineView.person = 250;
                                    }
                                }
                            }
                        }
                    }
                    catch (JSONException e){
                        e.printStackTrace();
                    }
                }
            }
        };
        mqtt2.setHandler2(handler2);
    }

    public void updateView(){

    }

    public void initViewPager(){
        viewList = new ArrayList<View>();// 将要分页显示的View装入数组中
        viewList.add(view1);
        viewList.add(view2);
        viewList.add(view3);
        viewList.add(view4);

        viewPager = (android.support.v4.view.ViewPager)findViewById(R.id.viewPager);

        PagerAdapter pagerAdapter = new PagerAdapter(){

            @Override
            public boolean isViewFromObject(View arg0, Object arg1) {
                return arg0 == arg1;
            }

            @Override
            public int getCount() {
                return viewList.size();
            }

            @Override
            public void destroyItem(ViewGroup container, int position,
                                    Object object) {
                container.removeView(viewList.get(position));
            }

            @Override
            public int getItemPosition(Object object) {
                return super.getItemPosition(object);
            }

            @Override
            public CharSequence getPageTitle(int position) {
                return titleList.get(position);//直接用适配器来完成标题的显示，所以从上面可以看到，我们没有使用PagerTitleStrip。当然你可以使用。
            }

            @Override
            public Object instantiateItem(ViewGroup container, int position) {
                container.addView(viewList.get(position));
                return viewList.get(position);
            }
        };
        viewPager.setAdapter(pagerAdapter);
    }

    public void initMainView(){
        doorB = (Button)view1.findViewById(R.id.door);
        personB = (Button)view1.findViewById(R.id.person);
        lineView = (LineView)view1.findViewById(R.id.line);

        text_fire = (TextView)view4.findViewById(R.id.fire_jump);
        text_fog = (TextView)view3.findViewById(R.id.fog_jump);
        text_temp = (TextView)view2.findViewById(R.id.temp_jump);

        text_temp.setOnClickListener(new View.OnClickListener(){
            String temp_url = "http://115.29.109.27/MonkeyGuard";
            @Override
            public void onClick(View v) {
                Intent intent = new Intent(MainActivity.this, WebActivity.class);
                Bundle bundle = new Bundle();
                intent.putExtras(bundle);
                intent.putExtra("url", temp_url);
//                intent.putExtra("imgData", imgData);

                startActivity(intent);
            }
        });

        text_fog.setOnClickListener(new View.OnClickListener(){
            String fog_url = "http://115.29.109.27/MonkeyGuard";
            @Override
            public void onClick(View v) {
                Intent intent = new Intent(MainActivity.this, WebActivity.class);
                Bundle bundle = new Bundle();
                intent.putExtras(bundle);
                intent.putExtra("url", fog_url);
//                intent.putExtra("imgData", imgData);

                startActivity(intent);
            }
        });

        text_fire.setOnClickListener(new View.OnClickListener(){
            String fire_url = "http://115.29.109.27/MonkeyGuard";
            @Override
            public void onClick(View v) {
                Intent intent = new Intent(MainActivity.this, WebActivity.class);
                Bundle bundle = new Bundle();
                intent.putExtras(bundle);
                intent.putExtra("url", fire_url);
//                intent.putExtra("imgData", imgData);

                startActivity(intent);
            }
        });

        doorB.setOnClickListener(new View.OnClickListener(){
            @Override
            public void onClick(View v) {
                if(doorFlag == false) {
                    doorFlag = true;
                    Toast.makeText(getApplicationContext(), "开启成功",
                            Toast.LENGTH_SHORT).show();
                    doorB.setText("关闭监测");
                }
                else{
                    doorFlag = false;
                    Toast.makeText(getApplicationContext(), "关闭成功",
                            Toast.LENGTH_SHORT).show();
                    if(lineView != null){
                        lineView.door = 150;
                        lineView.person = 150;
                    }
                    doorB.setText("开启监测");
                }
            }
        });

        personB.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                Intent intent = new Intent(MainActivity.this, MarkActivity.class);
                Bundle bundle = new Bundle();
                intent.putExtras(bundle);
                intent.putExtra("imgUrl", imgUrl);
//                intent.putExtra("imgData", imgData);

                startActivity(intent);
            }
        });
    }

    public void setMqtt(){
        mqtt.setBroker("tcp://115.29.109.27:61613");
        mqtt.setTopic("sensor");
        mqtt.setUserName("admin");
        mqtt.setPassword("password");
        mqtt.setContent("content");
        mqtt.setQos(1);
        String base = "abcdefghijklmnopqrstuvwxyz0123456789";
        Random random1 = new Random();
        Random random2 = new Random();

        int length = random2.nextInt(20);

        StringBuffer sb = new StringBuffer();
        for (int i = 0; i < length; i++) {
            int number = random1.nextInt(base.length());
            sb.append(base.charAt(number));
        }

        mqtt.setClientId(sb.toString());

        mqtt.init();
        mqtt.listen();
    }

    public void setMqtt2(){
        mqtt2.setBroker("tcp://115.29.109.27:61613");
        mqtt2.setTopic("door");
        mqtt2.setUserName("admin");
        mqtt2.setPassword("password");
        mqtt2.setContent("vcfbgsbgf");
        mqtt2.setQos(1);

        String base = "abcdefghijklmnopqrstuvwxyz0123456789";
        Random random1 = new Random();
        Random random2 = new Random();

        int length = random2.nextInt(20);

        StringBuffer sb = new StringBuffer();
        for (int i = 0; i < length; i++) {
            int number = random1.nextInt(base.length());
            sb.append(base.charAt(number));
        }

        mqtt2.setClientId(sb.toString());

        mqtt2.init();
        mqtt2.listen();
    }

    public void decodeJson(String jsonValue) throws JSONException{
        if(jsonValue != null){
            JSONObject sensorJson = new JSONObject(mqtt.ret);
            Iterator iterator = sensorJson.keys();
            int i = 0;
            while(iterator.hasNext()) {
                double d = Double.parseDouble(sensorJson.getString(sensorName[i]));
                senorValue[i] = (int) d;
                iterator.next();
                i++;
            }
        }
    }

    public void decodeJson2(String jsonValue) throws JSONException{
        if(jsonValue != null){
            JSONObject doorJson = new JSONObject(jsonValue);
            Iterator iterator = doorJson.keys();
            int i = 0;
            while(iterator.hasNext()) {
                double d = Double.parseDouble(doorJson.getString(doorName[i]));
                doorValue[i] = (int) d;
                iterator.next();
                i++;
            }
        }
    }

    public void initNotify(){
        mBuilder = new NotificationCompat.Builder(this);
        mBuilder.setContentTitle("测试标题")
                .setContentText("测试内容")
                .setContentIntent(getDefalutIntent(Notification.FLAG_AUTO_CANCEL))
                .setTicker("家中有异常情况")
                .setWhen(System.currentTimeMillis())
                .setPriority(Notification.PRIORITY_DEFAULT)
                .setOngoing(false)
                .setDefaults(Notification.DEFAULT_SOUND)
                .setSmallIcon(R.drawable.logo256);
    }

    public void showTempNotify(){
        mBuilder.setContentTitle("#温度#")
                .setContentText("家中温度异常，请及时查看")
                .setTicker("测试通知来啦");
        int requestCode = (int) System.currentTimeMillis();
        mNotificationManager.notify(106, mBuilder.build());
    }

    public void showFogNotify(){
        mBuilder.setContentTitle("#可燃气体#")
                .setContentText("家中可燃气体指数过高，请及时查看");
        int requestCode = (int) System.currentTimeMillis();
        mNotificationManager.notify(105, mBuilder.build());
    }

    public void showFireNotify(){
        mBuilder.setContentTitle("#火焰#")
                .setContentText("测到家中有火焰，请及时查看");
        int requestCode = (int) System.currentTimeMillis();
        mNotificationManager.notify(104, mBuilder.build());
    }

    public void showDoorNotify(){
        mBuilder.setContentTitle("#家门#")
                .setContentText("监测家门异常，请及时查看");
        int requestCode = (int) System.currentTimeMillis();
        mNotificationManager.notify(100, mBuilder.build());
    }

    public void showPersonNotify(){
        mBuilder.setContentTitle("#老人#")
                .setContentText("监测家中老人可能有摔倒情况，请及时查看");
        int requestCode = (int) System.currentTimeMillis();
        mNotificationManager.notify(101, mBuilder.build());
    }

    public void showImgNotify(){
        mBuilder.setContentTitle("#人员#")
                .setContentText("家中有人员来访，请及时查看");
        int requestCode = (int) System.currentTimeMillis();
        mNotificationManager.notify(103, mBuilder.build());
    }

    @Override
    public boolean onKeyDown(int keyCode, KeyEvent event) {
        if (keyCode == KeyEvent.KEYCODE_BACK) {
            moveTaskToBack(false);
            return true;
        }
        return super.onKeyDown(keyCode, event);
    }
}
