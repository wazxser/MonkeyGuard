package com.example.moon.monkeyguard;

import android.content.Context;
import android.graphics.Canvas;
import android.graphics.Color;
import android.graphics.Paint;
import android.graphics.Path;
import android.os.Handler;
import android.os.Message;
import android.util.AttributeSet;
import android.view.View;

import java.util.ArrayList;
import java.util.List;
import java.util.Random;

public class LineView extends View {
    public float temp = 30;
    public float fire = 35;
    public float fog = 300;
    public float person = 150;
    public float door = 150;
    public float image = 150;

    public LineView(Context context, AttributeSet attrs) {
        super(context, attrs);
    }

    @Override
    protected void onDraw(Canvas canvas) {
        super.onDraw(canvas);
        Paint p = new Paint();
        p.reset();//重置
        p.setColor(Color.parseColor("#33B5E5"));
        p.setStyle(Paint.Style.FILL);
        Path path1=new Path();
        path1.moveTo(350, 150);
        path1.lineTo(566, 275);
        path1.lineTo(566, 525);
        path1.lineTo(350, 650);
        path1.lineTo(134, 525);
        path1.lineTo(134, 275);
        path1.close();//封闭
        canvas.drawPath(path1, p);

        float temp2 = (temp / 50) * 250;
        float fire2 = (fire / 200) * 250;
        float fog2 = (fog / 500) * 250;
        float person2 = person;
        float door2 = door;
        float image2 = image;

        p.reset();
        p.setColor(Color.parseColor("#98FB98"));
        p.setStyle(Paint.Style.FILL);
        Path path2=new Path();
        path2.moveTo(350, 400 - temp2);
        path2.lineTo((350 + (fire2 / 2) * (float)1.732), 400 - fire2 / 2);
        path2.lineTo((float)(350 + (door2 / 2) * 1.732), 400 + door2 / 2);
        path2.lineTo(350, 400 + image2);
        path2.lineTo((float)(350 - (fog2 / 2) * 1.732), 400 + fog2 / 2);
        path2.lineTo((float)(350 - (person2 / 2) * 1.732), 400 - person2 / 2);
        path2.close();//封闭
        canvas.drawPath(path2, p);

        p.reset();
        p.setColor(Color.parseColor("#A8A8A8"));
        p.setTextSize((float)30.0);
        canvas.drawText("温度" + temp, 300, 138, p);
        canvas.drawText("火焰" + fire, 565, 285, p);
        canvas.drawText("家门", 565, 535, p);
        canvas.drawText("人员", 320, 680, p);
        canvas.drawText("可燃气体", 10, 525, p);
        canvas.drawText(String.valueOf(fog), 24, 555, p);
        canvas.drawText("老人摔倒", 18, 275, p);
    }
}
