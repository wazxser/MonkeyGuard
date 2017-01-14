package com.example.moon.monkeyguard;

import android.graphics.Bitmap;
import android.graphics.BitmapFactory;
import android.os.AsyncTask;
import android.os.Handler;
import android.widget.ImageView;

import org.json.JSONObject;

import java.io.BufferedInputStream;
import java.io.BufferedOutputStream;
import java.io.BufferedReader;
import java.io.BufferedWriter;
import java.io.IOException;
import java.io.InputStream;
import java.io.InputStreamReader;
import java.io.OutputStream;
import java.io.OutputStreamWriter;
import java.io.PrintStream;
import java.net.HttpURLConnection;
import java.net.MalformedURLException;
import java.net.URL;
import java.net.URLEncoder;

public class AcceptImage {
    String ip = "115.29.109.27";
    int port = 9526;
    ImageView image = null;
    String imgUrl = "nulll";
    Bitmap data = null;
    Handler imgHandler = null;

    public void setHandler(Handler handler){
        this.imgHandler = handler;
    }

    public String getImgUrl(){
        return this.imgUrl;
    }

    public Bitmap getData() {
        return this.data;
    }

    public void getImage(){
        Thread thread = new Thread(new Runnable() {
            @Override
            public void run() {
                try {
                    while(true) {
                        java.net.Socket socket = new java.net.Socket(ip, port);
//                        PrintStream out = new PrintStream(socket.getOutputStream());
//                        out.println("request mess");

                        InputStreamReader in = new InputStreamReader(socket.getInputStream());
                        BufferedReader buff = new BufferedReader(in);
                        String temp = buff.readLine();
                        System.out.println(temp);

                        if (!(temp.equals("no image"))) {
                            System.out.println(temp);
                            imgUrl = temp;
                            imgHandler.sendEmptyMessage(2);
//                            new DownImgAsyncTask().execute(imgUrl);
                        }
                        Thread.sleep(10000);
                    }
                } catch (Exception e) {
                    e.printStackTrace();
                }
            }
        });

        thread.start();
    }
}
//
//    java.io.DataInputStream din = new java.io.DataInputStream(sc
//            .getInputStream());
//if (din.available() > 0) {
//        data = new byte[din.readInt()];
//        din.read(data);
//
//        BufferedReader buf =  new BufferedReader(new InputStreamReader(sc.getInputStream()));
//        imgUrl = buf.readLine();
//        System.out.println(imgUrl);
//
//        System.out.println(imgUrl);
//
//        imgHandler.sendEmptyMessage(2);
//        }

