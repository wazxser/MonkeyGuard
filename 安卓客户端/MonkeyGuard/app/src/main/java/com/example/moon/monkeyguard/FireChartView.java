package com.example.moon.monkeyguard;

import android.content.Context;
import android.graphics.Canvas;
import android.graphics.Color;
import android.graphics.Paint;
import android.os.Handler;
import android.os.Message;
import android.util.AttributeSet;
import android.view.View;

import java.util.ArrayList;
import java.util.List;
import java.util.Random;

public class FireChartView extends View {
    private int XPoint = 100;
    private int YPoint = 600;
    private int XScale = 120;  //刻度长度
    private int YScale = 96;
    private int XLength = 600;
    private int YLength = 480;

    private int MaxDataSize = XLength / XScale;

    private List<Integer> data = new ArrayList<Integer>();

    private String[] YLabel = new String[YLength / YScale];

    private int message = 100;

    private Handler handler = new Handler(){
        public void handleMessage(Message msg) {
            if(msg.what == 0x1234){
                FireChartView.this.invalidate();
            }
        };
    };

    public void setMessage(int message){
        this.message = message;
    }

    public FireChartView(Context context, AttributeSet attrs) {
        super(context, attrs);
        int j = 0;
        for(int i = 0; i < YLabel.length; i++){
            YLabel[i] = String.valueOf(j);
            j = j + 50;
        }

        new Thread(new Runnable() {
            @Override
            public void run() {
                while(true){
                    try {
                        Thread.sleep(1000);
                    } catch (InterruptedException e) {
                        e.printStackTrace();
                    }
                    if(data.size() >= MaxDataSize){
                        data.remove(0);
                    }
                    data.add(message);
                    handler.sendEmptyMessage(0x1234);
                }
            }
        }).start();
    }

    @Override
    protected void onDraw(Canvas canvas) {
        super.onDraw(canvas);
        Paint paint = new Paint();
        paint.setStyle(Paint.Style.STROKE);
        paint.setAntiAlias(true); //去锯齿
        paint.setColor(Color.parseColor("#FFC125"));
        paint.setStrokeWidth(1.5f);
        paint.setTextSize(20);
        paint.setFakeBoldText(false);

//      画Y轴
        canvas.drawLine(XPoint, YPoint - YLength, XPoint, YPoint, paint);

//      Y轴箭头
        canvas.drawLine(XPoint, YPoint - YLength, XPoint - 3, YPoint-YLength + 6, paint);
        canvas.drawLine(XPoint, YPoint - YLength, XPoint + 3, YPoint-YLength + 6 ,paint);

        //添加刻度和文字
        for(int i=0; i * YScale < YLength; i++) {
            canvas.drawLine(XPoint, YPoint - i * YScale, XPoint + 5, YPoint - i * YScale, paint);  //刻度

            canvas.drawText(YLabel[i], XPoint - 40, YPoint - i * YScale + 10, paint);
        }

        //画X轴
        canvas.drawLine(XPoint, YPoint, XPoint + XLength, YPoint, paint);

        if(data.size() > 1){
            for(int i=1; i<data.size(); i++){
                float m = (float)data.get(i - 1);
                float startY = YPoint - m / 50 * YScale;
                float n = (float)data.get(i);
                float stopY = YPoint - n / 50 * YScale;
                canvas.drawLine(XPoint + (i-1) * XScale, startY, XPoint + i * XScale, stopY, paint);
            }
        }

        paint.reset();
        paint.setColor(Color.parseColor("#FFC125"));
        paint.setTextSize(30);
        canvas.drawText("实时数据", 90, 100, paint);
    }
}
